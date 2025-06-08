pipeline {
    agent any

    environment {
        PYTHON_ENV = 'venv'
    }

    stages {
        stage('Clone Repository') {
            steps {
                git  'https://github.com/veerababuteki/Icognito.ai.git'
'
            }
        }

        stage('Set Up Python Environment') {
            steps {
                sh '''
                    python3 -m venv $PYTHON_ENV
                    source $PYTHON_ENV/bin/activate
                    pip install --upgrade pip
                    pip install -r requirements.txt
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh '''
                    source $PYTHON_ENV/bin/activate
                    echo "No unit tests configured. Skipping for now."
                    # python -m unittest discover  # If you write tests
                '''
            }
        }

        stage('Build App') {
            steps {
                sh '''
                    source $PYTHON_ENV/bin/activate
                    echo "Build Step Completed"
                '''
            }
        }

        stage('Deploy') {
            steps {
                sshagent(['YOUR_SSH_CREDENTIAL_ID']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no user@server_ip "
                        cd /path/to/app &&
                        git pull origin main &&
                        source venv/bin/activate &&
                        pip install -r requirements.txt &&
                        pkill -f 'python3 apis.py' || true &&
                        nohup python3 apis.py > log.txt 2>&1 &
                        "
                    '''
                }
            }
        }
    }
}
