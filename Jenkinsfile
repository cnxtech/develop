#!/usr/bin/env groovy

// https://wiki.jenkins.io/display/JENKINS/Building+a+software+project
//// BUILD_NUMBER                The current build number, such as "153"
//// BUILD_ID                    The current build id, such as "2005-08-22_23-59-59" (YYYY-MM-DD_hh-mm-ss, defunct since version 1.597)
//// BUILD_URL                   The URL where the results of this build can be found (e.g. http://buildserver/jenkins/job/MyJobName/666/)
//// NODE_NAME                   The name of the node the current build is running on. Equals 'master' for master node.
//// JOB_NAME                    Name of the project of this build. This is the name you gave your job when you first set it up. It's the third column of the Jenkins Dashboard main page.
//// BUILD_TAG                   String of jenkins-${JOB_NAME}-${BUILD_NUMBER}. Convenient to put into a resource file, a jar file, etc for easier identification.
//// JENKINS_URL                 Set to the URL of the Jenkins master that's running the build. This value is used by Jenkins CLI for example
//// EXECUTOR_NUMBER             The unique number that identifies the current executor (among executors of the same machine) that's carrying out this build. This is the number you see in the "build executor status", except that the number starts from 0, not 1.
//// JAVA_HOME                   If your job is configured to use a specific JDK, this variable is set to the JAVA_HOME of the specified JDK. When this variable is set, PATH is also updated to have $JAVA_HOME/bin.
//// WORKSPACE                   The absolute path of the workspace.
//// SVN_REVISION                For Subversion-based projects, this variable contains the revision number of the module. If you have more than one module specified, this won't be set.
//// CVS_BRANCH                  For CVS-based projects, this variable contains the branch of the module. If CVS is configured to check out the trunk, this environment variable will not be set.
//// GIT_COMMIT                  For Git-based projects, this variable contains the Git hash of the commit checked out for the build (like ce9a3c1404e8c91be604088670e93434c4253f03) (all the GIT_* variables require git plugin)
//// GIT_URL                     For Git-based projects, this variable contains the Git url (like git@github.com:user/repo.git or [https://github.com/user/repo.git])
//// GIT_BRANCH                  For Git-based projects, this variable contains the Git branch that was checked out for the build (normally origin/master)


node {
    withEnv([
        'BACKEND_PORT=39967',
        'IS_JENKINS=1'
    ]) {
        stage('SCM') {
//            checkout scm
            checkout([
                $class           : 'GitSCM',
                branches         : scm.branches,
                extensions       : scm.extensions + [
                    [$class: 'WipeWorkspace'],
                    [
                        $class             : 'SubmoduleOption',
                        disableSubmodules  : false,
                        parentCredentials  : false,
                        recursiveSubmodules: true,
                        reference          : '',
                        trackingSubmodules : false,
//                        parentCredentials  : true,
                    ]
                ],
                userRemoteConfigs: scm.userRemoteConfigs,
//                submoduleCfg                  : []
            ])
            sh 'git submodule update --init --remote --force'
        }

//        stage('frontend: install') {
//            sh 'scripts/ci.sh frontend-install'
//        }
//
//        stage('frontend: build') {
//            sh 'scripts/ci.sh frontend-build'
//        }
//
//        stage('frontend: post-build') {
//            sh 'mkdir -p html_reports'
//
//            stage('publish bundle-analyzer') {
//                sh 'mkdir -p html_reports/bundle-analyzer'
//                sh 'cp -f theme/app/dist/bundle-analyzer.html html_reports/bundle-analyzer/index.html'
//                publishHTML([
//                    allowMissing: false,
//                    alwaysLinkToLastBuild: false,
//                    keepAll: true,
//                    reportDir: 'html_reports/bundle-analyzer',
//                    reportFiles: 'index.html',
//                    reportName: 'Bundle Analyzer',
//                    reportTitles: ''
//                ])
//            }
//        }


        stage('backend: install') {
            sh 'scripts/ci.sh backend-install'
        }
        stage('backend: tests') {
            echo 'todo'
        }
        parallel {
            stage('backend: serve') {
                sh 'scripts/ci.sh backend-serve'
            }
            stage('backend: post-serve') {
                echo 'todo'
            }
        }

    }
}


