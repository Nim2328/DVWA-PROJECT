# SQL Injection Vulnerability Remediation

## 1. Vulnerability Overview

The DVWA SQL Injection module was identified as vulnerable to SQL Injection because user-controlled input was directly incorporated into database queries.

An attacker could provide specially crafted input to alter the intended SQL query and retrieve unintended database records.

**Affected file:**

`vulnerabilities/sqli/source/low.php`

---

## 2. Baseline Vulnerability

Before remediation, the application accepted user input and used it directly in the SQL query.

A SQL Injection payload such as:

```text
' OR '1'='1
