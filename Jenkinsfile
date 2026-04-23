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
                // Quét nhưng không cho dừng pipeline (exit-code 0) để bạn dễ theo dõi kết quả lần đầu
                sh "trivy image --severity HIGH,CRITICAL --exit-code 0 ${IMAGE_NAME}"
            }
        }

        stage('☁️ Push to Docker Hub') {
            steps {
                sh 'docker push ${IMAGE_NAME}'
            }
        }

        stage('🚀 Deploy to AWS EC2') {
            steps {
                sh '''
                ssh -o StrictHostKeyChecking=no $EC2_USER@$EC2_IP "
                    cd $EC2_DIR &&
                    export DB_PASSWORD=\\$SECRET_DB_PASS &&
                    docker-compose pull web &&
                    docker-compose up -d
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
