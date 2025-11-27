# Email Authentication Configuration (DNS)

To ensure high deliverability and prevent your emails from landing in spam, you must configure the following DNS records for your domain.

## 1. SPF (Sender Policy Framework)
Add a TXT record to authorize the server/provider to send emails on your behalf.

**Type**: TXT
**Host**: @
**Value**:
- If using **Option A (Own Server)**: `v=spf1 mx ~all`
- If using **Option B (Provider)**: Check your provider's docs (e.g., `v=spf1 include:mailgun.org ~all`)

## 2. DKIM (DomainKeys Identified Mail)
DKIM signs your emails with a cryptographic key.

**Type**: TXT
**Host**: `default._domainkey` (or selector provided by admin/provider)
**Value**:
- **Option A**: Generate key with `opendkim-genkey` and paste the public key here.
- **Option B**: Copy the value provided by your SMTP provider dashboard.

## 3. DMARC (Domain-based Message Authentication, Reporting, and Conformance)
DMARC tells receivers what to do if SPF/DKIM fail.

**Type**: TXT
**Host**: `_dmarc`
**Value**: `v=DMARC1; p=none; rua=mailto:admin@yourdomain.com`
- Start with `p=none` (monitor mode).
- Move to `p=quarantine` or `p=reject` after verifying everything works.

## 4. Reverse DNS (PTR) - *Option A Only*
If hosting your own server, ensure your hosting provider sets a PTR record for your IP address pointing to your mail hostname (e.g., `mail.yourdomain.com`).
