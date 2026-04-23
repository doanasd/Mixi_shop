pipeline {
    // Chạy trên bất kỳ máy chủ Jenkins (Agent) nào có sẵn
    agent any

    // Khai báo các Biến Môi Trường dùng chung cho toàn bộ Pipeline
    environment {
        // 1. Mật khẩu RDS (Được Jenkins bảo mật tuyệt đối, kéo ra từ Credentials Manager)
        SECRET_DB_PASS = credentials('RDS_DB_PASS')
        
        // 2. Thông tin Image trên Docker Hub
        IMAGE_NAME = "doanasd/mixi_shop:latest"
        
        // 3. Thông tin máy chủ EC2 Web (Kết nối qua mạng ẩn Tailscale)
        // LƯU Ý: Bạn hãy sửa lại tên user và IP cho khớp với thực tế máy của bạn nhé!
        EC2_USER = "doanvw" 
        EC2_IP = "100.109.127.58" 
        EC2_DIR = "/home/doanvw/mixi_shop" 
    }

    stages {
        stage('🛠️ Build Image') {
            steps {
                echo 'Bắt đầu Build Docker Image từ mã nguồn mới nhất...'
                sh 'docker build -t ${IMAGE_NAME} .'
            }
        }

        stage('☁️ Push to Docker Hub') {
            steps {
                echo 'Đẩy Image vừa Build lên kho chứa Docker Hub...'
                // LƯU Ý: Nếu Jenkins báo lỗi không có quyền push, bạn cần cấu hình thêm phần 'docker login' ở đây.
                // Tạm thời nếu máy ảo Jenkins đã login sẵn docker rồi thì lệnh push sẽ chạy luôn.
                sh 'docker push ${IMAGE_NAME}'
            }
        }
        
        stage('🛡️ Security Scan (Trivy)') {
            steps {
                echo 'Đang quét lỗ hổng bảo mật cho Image...'
                // Quét lỗ hổng mức độ High và Critical, nếu có lỗi sẽ dừng Pipeline
                sh "trivy image --severity HIGH,CRITICAL --exit-code 1 ${IMAGE_NAME}"
            }
        }

        stage('🚀 Deploy to AWS EC2 (Zero-Trust)') {
            steps {
                echo 'Chui qua hầm Tailscale để ra lệnh cho EC2 Web Server cập nhật...'
                
                // Lệnh ssh dùng cờ StrictHostKeyChecking=no để không bị hỏi Yes/No khi kết nối lần đầu
                // Biến SECRET_DB_PASS được truyền vào như một biến môi trường tạm thời
                sh """
                ssh -o StrictHostKeyChecking=no ${EC2_USER}@${EC2_IP} '
                    cd ${EC2_DIR} &&
                    export DB_PASSWORD="${SECRET_DB_PASS}" &&
                    docker-compose pull web &&
                    docker-compose up -d
                '
                """
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
