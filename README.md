# Securing DVWA Through Secure Coding and DevSecOps Automation

## Project Overview
This repository contains a hardened implementation of the **Damn Vulnerable Web Application (DVWA)**, containerised with Docker Compose and integrated into an automated **DevSecOps CI/CD Pipeline** using GitHub Actions.

Four critical web application vulnerabilities were identified, exploited in an isolated test environment, remediated via secure coding practices, and validated using Static Application Security Testing (SAST).

---

## Application Architecture & Containerisation
- **Web Tier:** DVWA running on PHP 8 / Apache exposed on `127.0.0.1:4280`
- **Database Tier:** MariaDB database connected over an isolated Docker bridge network
- **Secrets Management:** Environment variables injected at runtime via encrypted GitHub Secrets (no credentials tracked in source control)

---

## Vulnerability Remediation Summary

### 1. SQL Injection (`vulnerabilities/sqli/source/low.php`)
- **Vulnerability:** Untrusted user input directly concatenated into SQL queries.
- **Remediation:** Enforced strict integer type validation and implemented parameterized prepared statements (`PDO`).

### 2. Reflected Cross-Site Scripting (XSS) (`vulnerabilities/xss_r/source/low.php`)
- **Vulnerability:** Unsanitized `GET` input reflected directly in the HTML response.
- **Remediation:** Applied context-aware output encoding using `htmlspecialchars()` with `ENT_QUOTES | ENT_SUBSTITUTE` and UTF-8 charset.

### 3. Operating System Command Injection (`vulnerabilities/exec/source/low.php`)
- **Vulnerability:** Unescaped input concatenated directly into system shell calls (`shell_exec`).
- **Remediation:** Implemented strict input validation via `filter_var(..., FILTER_VALIDATE_IP)` / hostname regex, wrapped execution parameters with `escapeshellarg()`, and escaped output.

### 4. Malicious File Upload (`vulnerabilities/upload/source/low.php`)
- **Vulnerability:** Unrestricted file uploads allowing arbitrary PHP web shells.
- **Remediation (5-Layer Defense-in-Depth):**
  1. Upload error code verification (`UPLOAD_ERR_OK`).
  2. File size restriction (enforced 2 MB limit).
  3. Strict extension whitelist (`jpg`, `jpeg`, `png`, `gif`).
  4. Server-side MIME & Magic Byte inspection using PHP `finfo`.
  5. Cryptographically secure randomized server-side filenames (`random_bytes(16)`).

---

## DevSecOps CI/CD Security Pipeline

The pipeline triggers automatically on all pushes and pull requests via GitHub Actions (`.github/workflows/ci.yml`).

| Security Gate | Tool | Target / Scope | Expected Status |
| :--- | :--- | :--- | :--- |
| **Application Build** | Docker Compose | `compose.yml` & `Dockerfile` | **PASS** |
| **SAST** | Semgrep (`p/php`) | 4 Remediated vulnerability sources | **PASS (0 findings)** |
| **SCA** | Composer Audit | `vulnerabilities/api/composer.lock` | **PASS (0 vulnerabilities)** |
| **Secrets Scanning** | Gitleaks | Entire repository commit history | **PASS (No leaks)** |
| **Container Security** | Trivy | `ghcr.io/digininja/dvwa:latest` | **FAIL (Intentional Gate Triggered)** |

> **Note on Container Security Failure:** The Trivy container scan intentionally exits with code `1` due to 34 vulnerabilities (22 High, 12 Critical) located in the Debian base operating system layer. This provides concrete evidence of an active, build-breaking DevSecOps policy gate.

---

## Team Contributions
- **IT24100947 (Malintha H.M.D.H):** Command Injection remediation & analysis
- **IT24100995 (Gunarathne R D M N):** Reflected XSS remediation & validation
- **IT24102340 (Nayanajith K.M.N.S):** SQL Injection remediation & project setup
- **IT24101128 (Jayathungage D.K.C):** Malicious File Upload 5-layer remediation, CI/CD pipeline integration & repository consolidation
