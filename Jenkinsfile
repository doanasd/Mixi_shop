pipeline {
    agent any
    
    environment {
        // Cấu hình máy chủ đích và Docker Hub
        DOCKER_IMAGE = "doanasd/mixi_shop:latest"
        APP_SERVER_USER = "doanvw"
        APP_SERVER_IP = "192.168.100.144"
        
        // Lấy thông tin xác thực từ Jenkins Credentials
        DB_PASSWORD = credentials('db-password-id') 
        DOCKER_CREDS = credentials('docker-hub-creds')
    }
    
    stages {
        stage('Checkout Code') {
            steps {
                echo 'Kéo mã nguồn từ GitHub...'
                checkout scm
            }
        }
        
        stage('Security Scan (SAST)') {
            steps {
                echo 'Quét mã nguồn bằng Semgrep (Audit Mode)...'
                // Chạy Semgrep nhưng không đánh sập Pipeline nếu có lỗi
                sh 'semgrep --config auto . || true'
            }
        }
        
        stage('Build Docker Image') {
            steps {
                echo 'Đóng gói Docker Image...'
                sh 'docker build -t $DOCKER_IMAGE .'
            }
        }
        
        stage('Push to Docker Hub') {
            steps {
                echo 'Đẩy Image lên Docker Hub...'
                sh '''
                echo $DOCKER_CREDS_PSW | docker login -u $DOCKER_CREDS_USR --password-stdin
                docker push $DOCKER_IMAGE
                '''
            }
        }
        
        stage('Deploy to Web Server') {
            steps {
                echo 'Triển khai lên server qua SSH...'
                sshagent(['vps-ssh-key']) {
                    sh """
                    # 1. Tạo thư mục và copy file cấu hình sang server
                    ssh -o StrictHostKeyChecking=no ${APP_SERVER_USER}@${APP_SERVER_IP} "mkdir -p ~/mixi_shop/DB"
                    scp -o StrictHostKeyChecking=no docker-compose.yml ${APP_SERVER_USER}@${APP_SERVER_IP}:~/mixi_shop/
                    scp -o StrictHostKeyChecking=no DB/mixi_shop.sql ${APP_SERVER_USER}@${APP_SERVER_IP}:~/mixi_shop/DB/
                    
                    # 2. Thực thi lệnh triển khai trên server
                    ssh -o StrictHostKeyChecking=no ${APP_SERVER_USER}@${APP_SERVER_IP} '''
                        cd ~/mixi_shop
                        export DB_PASSWORD=${DB_PASSWORD}
                        docker-compose pull
                        docker-compose down
                        docker-compose up -d
                    '''
                    """
                }
            }
        }
    }
    
    post {
        always {
            echo 'Dọn dẹp môi trường Jenkins sau khi chạy...'
            sh 'docker logout || true'
            sh 'docker image prune -f || true'
        }
    }
}
