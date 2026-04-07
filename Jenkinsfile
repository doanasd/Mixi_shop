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
                // Sử dụng Semgrep hoặc Trivy như bạn đã dự định trong tài liệu cải tiến
                sh 'semgrep --config auto .'
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
