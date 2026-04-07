pipeline {
    agent any
    environment {
        DB_PASSWORD = credentials('db-password-id') // Lấy pass từ Jenkins Credentials
    }
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('Security Scan') {
            steps {
                echo 'Quét mã nguồn bằng Semgrep (Audit Mode)...'
                // Thêm "|| true" ở cuối để Jenkins luôn coi bước này là SUCCESS dù Semgrep có chửi rủa thế nào đi nữa
                sh 'semgrep --config auto . || true'
            }
        }
        stage('Build Docker Image') {
            steps {
                sh 'docker-compose build'
            }
        }
        stage('Test Run') {
            steps {
                sh 'docker-compose up -d'
                // Thêm các câu lệnh test kết nối tại đây
            }
        }
    }
    post {
        always {
            sh 'docker-compose down'
        }
    }
}
