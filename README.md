# DVWA DevSecOps Security Project

## 1. Project Overview

This project demonstrates the application of DevSecOps practices to the Damn Vulnerable Web Application (DVWA), an intentionally vulnerable open-source web application designed for security testing and education.

The project deploys DVWA in a controlled Docker environment and demonstrates the integration of security throughout the software development lifecycle. The implementation includes threat modelling, vulnerability assessment, secure coding remediation, automated security testing, dependency scanning, secrets scanning, and container image security scanning.

## 2. Technology Stack

* Damn Vulnerable Web Application (DVWA)
* PHP
* Apache
* MariaDB
* Docker
* Docker Compose
* Kali Linux
* Git and GitHub
* GitHub Actions
* SAST tools
* Dependency scanning tools
* Gitleaks
* Trivy
* HashiCorp Vault

## 3. System Architecture

The application consists of two Docker services:

1. **DVWA Web Application**

   * PHP and Apache based web application
   * Exposed locally through port `4280`
   * Connects to MariaDB through the Docker internal network

2. **MariaDB Database**

   * Stores DVWA application data
   * Accessible through the internal Docker network
   * Persistent storage is provided through a Docker volume

The services communicate through the Docker network named `dvwa`.

## 4. Prerequisites

The following software is required:

* Docker
* Docker Compose
* Git
* Kali Linux or another Linux-based security testing environment

Verify Docker installation:

```bash
docker --version
```

Verify Docker Compose:

```bash
docker compose version
```

## 5. Installation and Setup

Clone the project repository:

```bash
git clone <REPOSITORY_URL>
```

Navigate to the project directory:

```bash
cd IE3142-DVWA
```

Build the Docker images:

```bash
docker compose build
```

Start the application:

```bash
docker compose up -d
```

Check the running containers:

```bash
docker compose ps
```

The DVWA application can then be accessed locally using:

```text
http://127.0.0.1:4280
```

## 6. Stopping the Environment

To stop the running containers without removing them:

```bash
docker compose stop
```

To stop and remove the containers and network:

```bash
docker compose down
```

The persistent database volume is retained unless it is explicitly removed.

## 7. Security Testing Scope

All vulnerability demonstrations and security testing are performed against the locally deployed DVWA instance within a controlled academic environment.

Testing is limited to the project environment and is not performed against third-party systems.

## 8. DevSecOps Pipeline

The project progressively integrates security checks into the CI/CD workflow.

The planned automated security gates include:

* Static Application Security Testing (SAST)
* Dependency/SCA scanning
* Secrets scanning
* Container image scanning using Trivy

The pipeline is designed to identify security issues before vulnerable code reaches the final deployment stage.

## 9. Project Objectives

The main objectives are to:

* Identify realistic web application security vulnerabilities.
* Demonstrate vulnerabilities in the intentionally vulnerable application.
* Apply secure coding fixes.
* Verify that the original exploits are no longer successful.
* Integrate automated security testing into CI/CD.
* Prevent insecure dependencies and secrets from reaching the repository.
* Scan container images for known vulnerabilities.
* Demonstrate practical DevSecOps security integration.

## 10. Academic Use

This project is developed for academic purposes as part of the IE3142 DevSecOps assessment. The vulnerable application is intentionally used in a controlled environment to demonstrate security testing, remediation, and automation techniques.
