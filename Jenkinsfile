pipeline {
    agent any

    environment {
        // Gọi ID Credentials bạn đã tạo trên Jenkins
        SECRET_DB_PASS = credentials('RDS_DB_PASS')
        IMAGE_NAME = "doanasd/mixi_shop:latest"
        EC2_USER = "doanvw"
        EC2_IP = "100.109.127.58"
        EC2_DIR = "/home/doanvw/mixi_shop"
    }

    stages {
        stage('🛠️ Build Docker Image') {
            steps {
                echo 'Bắt đầu đóng gói Image...'
                sh "docker build -t ${IMAGE_NAME} ."
            }
        }

        stage('🛡️ Security Scan (Trivy)') {
            steps {
                echo 'Đang quét lỗ hổng bảo mật Image...'
                // Quét mức độ Cao và Nghiêm trọng, không dừng pipeline để bạn theo dõi kết quả
                sh "trivy image --skip-version-check --severity HIGH,CRITICAL --exit-code 0 ${IMAGE_NAME}"
            }
        }

        stage('☁️ Push to Docker Hub') {
            steps {
                echo 'Đẩy Image lên Docker Hub...'
                sh "docker push ${IMAGE_NAME}"
            }
        }

        stage('🚀 Deploy to AWS EC2') {
            steps {
                echo 'Đồng bộ cấu hình và cập nhật Container trên EC2...'
                sh '''
                # Gửi file cấu hình sang EC2
                scp -o StrictHostKeyChecking=no docker-compose.yml $EC2_USER@$EC2_IP:$EC2_DIR/docker-compose.yml

                # Truy cập EC2 và triển khai
                ssh -o StrictHostKeyChecking=no $EC2_USER@$EC2_IP "
                    cd $EC2_DIR &&
                    docker-compose pull web &&
                    # Export biến rõ ràng trước khi chạy UP
                    export DB_PASSWORD='${SECRET_DB_PASS}' &&
                    docker-compose up -d --force-recreate --remove-orphans
                "
                '''
            }
        }
    }

    post {
        always {
            echo 'Dọn dẹp không gian làm việc...'
            cleanWs()
        }
        success {
            echo '✅ CHÚC MỪNG: Hệ thống đã triển khai thành công và an toàn!'
        }
    }
}
