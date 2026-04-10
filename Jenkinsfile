pipeline {
    agent any

    environment {
        // --- CẤU HÌNH BIẾN MÔI TRƯỜNG ---
        // Đổi 'doanasd/mixi_shop' thành tên Repo Docker Hub thực tế của bạn
        DOCKER_IMAGE = 'doanasd/mixi_shop:latest' 
        
        // ID của Credentials chứa User/Pass Docker Hub trên Jenkins
        DOCKER_CREDS = credentials('dockerhub-creds') 
        
        // Cấu hình AWS & Tailscale
        AWS_IP = '100.109.127.58'
        REMOTE_USER = 'doanvw'
        REMOTE_DIR = '/home/doanvw/mixi_shop'
        
        // Mật khẩu Database (Trong thực tế nên dùng credentials('db-pass'), ở đây hardcode để test)
        DB_PASSWORD = 'Secret123!' 
    }

    stages {
        stage('Source Code Checkout') {
            steps {
                echo "Đang kéo mã nguồn mới nhất từ GitHub..."
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                echo "Đang đóng gói ứng dụng thành Docker Image..."
                sh "docker build -t ${DOCKER_IMAGE} ."
            }
        }

        stage('Push to Docker Hub') {
            steps {
                echo "Đang đăng nhập vào Docker Hub..."
                sh "echo \$DOCKER_CREDS_PSW | docker login -u \$DOCKER_CREDS_USR --password-stdin"
                
                echo "Đang đẩy Image lên Docker Hub..."
                sh "docker push ${DOCKER_IMAGE}"
            }
        }

        stage('Deploy to AWS via Tailscale') {
            steps {
                // Sử dụng ID của SSH Key bạn vừa tạo ở Bước 1
                sshagent(['aws-ssh-key']) {
                    script {
                        echo "Đang triển khai lên AWS EC2 (${AWS_IP})..."

                        // 1. Tạo thư mục chứa source code, thư mục DB và file rỗng cho log Honeypot trên AWS
                        sh """
                            ssh -o StrictHostKeyChecking=no ${REMOTE_USER}@${AWS_IP} 'mkdir -p ${REMOTE_DIR}/DB && touch ${REMOTE_DIR}/honeypot.log'
                        """

                        // 2. Ném file docker-compose.yml và file SQL khởi tạo DB qua hầm Tailscale sang AWS
                        sh """
                            scp -o StrictHostKeyChecking=no docker-compose.yml ${REMOTE_USER}@${AWS_IP}:${REMOTE_DIR}/
                            scp -o StrictHostKeyChecking=no ./DB/mixi_shop.sql ${REMOTE_USER}@${AWS_IP}:${REMOTE_DIR}/DB/
                        """

                        // 3. Chạy lệnh Pull image mới và khởi động lại Docker Compose trên AWS
                        sh """
                            ssh -o StrictHostKeyChecking=no ${REMOTE_USER}@${AWS_IP} 'cd ${REMOTE_DIR} && export DB_PASSWORD=${DB_PASSWORD} && docker-compose down && docker-compose pull && docker-compose up -d'
                        """
                    }
                }
            }
        }
    }

    post {
        always {
            echo 'Quy trình Pipeline đã kết thúc. Đang dọn dẹp hệ thống...'
            // Lệnh dọn rác Docker cũ trên Jenkins để tránh đầy ổ cứng
            sh 'docker image prune -f' 
        }
        success {
            echo '✅ XUẤT SẮC! Đã triển khai thành công lên môi trường AWS DevSecOps!'
        }
        failure {
            echo '❌ PIPELINE THẤT BẠI. Vui lòng kiểm tra lại log chi tiết.'
        }
    }
}
