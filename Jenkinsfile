pipeline {
    agent any

    environment {
        // Gọi các Credentials đã cấu hình trên Jenkins
        DOCKER_CREDS = credentials('dockerhub-creds') 
        SECRET_DB_PASS = credentials('RDS_DB_PASS')
        
        // Các biến môi trường của dự án
        IMAGE_NAME = "doanasd/mixi_shop:latest"
        EC2_USER = "doanvw"
        EC2_DIR = "/home/doanvw/mixi_shop"
        
        // Danh sách IP Tailscale của các Web Server (Web1, Web2)
        SERVER_LIST = "100.109.127.58, 100.121.118.74" 
    }

    stages {
        stage('📦 Build Image') {
            steps {
                echo 'Đang tiến hành Build Docker Image...'
                sh "docker build -t ${IMAGE_NAME} ."
            }
        }

        stage('🛡️ Security Scan (Trivy)') {
            steps {
                echo 'Đang quét lỗ hổng bảo mật với Trivy...'
                // Đã tối ưu hóa: Thêm timeout 15 phút, bỏ qua check version và chỉ định quét vuln (rút ngắn thời gian quét)
                sh "trivy image --timeout 15m --skip-version-check --scanners vuln --severity HIGH,CRITICAL ${IMAGE_NAME}"
            }
        }

        stage('🚀 Push Image to Docker Hub') {
            steps {
                echo 'Đang đẩy Image lên Docker Hub...'
                withCredentials([usernamePassword(credentialsId: 'dockerhub-creds', passwordVariable: 'DOCKER_PASSWORD', usernameVariable: 'DOCKER_USERNAME')]) {
                    sh """
                    echo \$DOCKER_PASSWORD | docker login -u \$DOCKER_USERNAME --password-stdin
                    docker push ${IMAGE_NAME}
                    """
                }
            }
        }

        stage('🌐 Deploy to Multi-Server (HA)') {
            steps {
                script {
                    // Chuyển chuỗi SERVER_LIST thành mảng
                    def servers = SERVER_LIST.split(',').collect { it.trim() }
                    
                    // Vòng lặp SSH vào từng server để Deploy
                    for (int i = 0; i < servers.size(); i++) {
                        def target_ip = servers[i]
                        
                        withCredentials([string(credentialsId: 'RDS_DB_PASS', variable: 'SECRET_DB_PASS')]) {
                            echo "=========================================="
                            echo "Đang triển khai tới Server: ${target_ip}"
                            echo "=========================================="
                            
                            // 1. Copy file docker-compose.yml sang server
                            sh "scp -o StrictHostKeyChecking=no docker-compose.yml ${EC2_USER}@${target_ip}:${EC2_DIR}/"
                            
                            // 2. SSH vào server, truyền mật khẩu DB và khởi động lại container
                            sh """
                            ssh -o StrictHostKeyChecking=no ${EC2_USER}@${target_ip} "
                                cd ${EC2_DIR} &&
                                export DB_PASSWORD='${SECRET_DB_PASS}' &&
                                docker compose pull web &&
                                docker compose down &&
                                docker compose up -d --force-recreate --remove-orphans
                            "
                            """
                        }
                    }
                }
            }
        }
    }

    post {
        always {
            echo 'Quá trình CI/CD Pipeline đã hoàn tất!'
            // Dọn dẹp session docker login để bảo mật
            sh 'docker logout'
        }
        success {
            echo '✅ Triển khai thành công lên toàn bộ hệ thống!'
        }
        failure {
            echo '❌ Có lỗi xảy ra trong quá trình triển khai.'
        }
    }
}
