pipeline {
    agent any
    environment {
        SECRET_DB_PASS = credentials('RDS_DB_PASS')
        IMAGE_NAME = "doanasd/mixi_shop:latest"
        EC2_USER = "doanvw"
        EC2_IP = "100.109.127.58"
        EC2_DIR = "/home/doanvw/mixi_shop"
    }

    stages {
        stage('🛠️ Build Image') {
            steps {
                sh 'docker build -t ${IMAGE_NAME} .'
            }
        }

        stage('🛡️ Security Scan') {
            steps {
                // Thêm các cờ để Trivy in ra bảng kết quả và bỏ qua kiểm tra phiên bản cho nhanh
                sh "trivy image --skip-version-check --severity HIGH,CRITICAL --exit-code 0 ${IMAGE_NAME}"
            }
        }

        stage('☁️ Push to Docker Hub') {
            steps {
                sh 'docker push ${IMAGE_NAME}'
            }
        }

         stage('🚀 Deploy to AWS EC2') {
            steps {
                echo 'Gửi file cấu hình và cập nhật hệ thống trên EC2...'
                sh '''
                # 1. Gửi file docker-compose.yml từ Jenkins sang EC2 trước khi ra lệnh deploy
                scp -o StrictHostKeyChecking=no docker-compose.yml $EC2_USER@$EC2_IP:$EC2_DIR/docker-compose.yml

                # 2. Thực thi lệnh cập nhật qua SSH
                ssh -o StrictHostKeyChecking=no $EC2_USER@$EC2_IP "
                    cd $EC2_DIR &&
                    # Sử dụng lệnh up -d để cập nhật container với biến môi trường mới
                    DB_PASSWORD='${SECRET_DB_PASS}' docker-compose up -d --remove-orphans
                "
                '''
            }
        }
    }
    // Các hành động dọn dẹp và thông báo sau khi Pipeline chạy xong
    post {
        success {
            echo '✅ XUẤT SẮC: Hệ thống đã Deploy phiên bản mới thành công!'
        }
        failure {
            echo '❌ THẤT BẠI: Quá trình Deploy gặp lỗi. Vui lòng đọc Console Output ở trên để gỡ rối.'
        }
        always {
            // Xóa sạch thư mục tạm của Jenkins để tránh đầy ổ cứng
            cleanWs()
        }
    }
}
