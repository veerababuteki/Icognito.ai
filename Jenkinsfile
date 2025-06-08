pipeline {
    agent any

    environment {
        VENV_DIR = 'venv'
    }

    stages {
        stage('Set Up Python Environment') {
            steps {
                sh '''
                    python3 -m venv $VENV_DIR
                    source $VENV_DIR/bin/activate
                    pip install --upgrade pip
                    pip install -r Icognito_Updated/Icognito_Updated/requirements.txt
                '''
            }
        }

        stage('Run App') {
            steps {
                sh '''
                    source $VENV_DIR/bin/activate
                    cd Icognito_Updated/Icognito_Updated
                    nohup python3 apis.py > flask.log 2>&1 &
                '''
            }
        }
    }
}
