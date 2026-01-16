# Pflege-WG Rechtsfinder – DB Schema (PostgreSQL, aktuell normalisiert)

> Stand: PostgreSQL Production Schema mit normalisiertem ER-Modell

## Aktuelle Tabellen (PostgreSQL)

### wgs

| Spalte | Typ | Constraint |
|--------|-----|------------|
| `wg_id` | UUID | PK |
| `wg_name` | VARCHAR | |
| `address_text` | TEXT | |
| `state` | VARCHAR | |
| `district` | VARCHAR | |
| `municipality` | VARCHAR | |
| `governance` | VARCHAR | |
| `residents_total` | INTEGER | |
| `residents_with_pg` | INTEGER | |
| `target_group` | VARCHAR | |
| `has_24h_presence` | BOOLEAN | |
| `has_presence_staff` | BOOLEAN | |
| `care_provider_mode` | VARCHAR | |
| `lease_individual` | BOOLEAN | |
| `care_individual` | BOOLEAN | |
| `bundle_housing_care` | BOOLEAN | |
| `sgb_xi_used` | BOOLEAN | |
| `sgb_xii_involved` | BOOLEAN | |
| `sgb_v_hkp` | BOOLEAN | |
| `landesrecht_title` | VARCHAR | |
| `landesrecht_url` | VARCHAR | |
| `heimaufsicht_contact_hint` | TEXT | |
| `notes` | TEXT | |
| `created_at` | TIMESTAMPTZ | |
| `updated_at` | TIMESTAMPTZ | |

### cases

| Spalte | Typ | Constraint | Beschreibung |
|--------|-----|-----------|---------|
| `case_id` | UUID | PK | Eindeutige Case-ID |
| `wg_id` | UUID | FK → wgs | Welche WG |
| `created_by_user_id` | BIGINT | FK → users | Wer hat es erstellt |
| `case_title` | VARCHAR | NOT NULL | |
| `status` | VARCHAR | ENUM (OPEN,IN_PROGRESS,WAITING,DONE,ARCHIVED) | |
| `problem_description` | TEXT | NOT NULL | |
| `priority` | VARCHAR | ENUM (LOW,MEDIUM,HIGH,CRITICAL) | |
| `required_docs` | TEXT | NULL | Semikolon-separiert oder JSON |
| `next_actions` | TEXT | NULL | |
| `deadlines` | TEXT | NULL | |
| `source_links` | TEXT | NULL | |
| `attachments` | TEXT | NULL | |
| `last_reviewed_at` | TIMESTAMPTZ | NULL | |
| `created_at` | TIMESTAMPTZ | | |
| `updated_at` | TIMESTAMPTZ | | |

### issues

| Spalte | Typ | Constraint | Beschreibung |
|--------|-----|-----------|---------|
| `id` | UUID | PK | |
| `code` | VARCHAR | UNIQUE | z.B. "HOUSING_38A" |
| `name` | VARCHAR | NOT NULL | |
| `description` | TEXT | | |
| `default_authority_targets` | TEXT | | |
| `default_required_docs` | TEXT | | |
| `default_next_actions` | TEXT | | |
| `default_source_links` | TEXT | | |
| `rule_hints` | TEXT | | |
| `created_at` | TIMESTAMPTZ | | |
| `updated_at` | TIMESTAMPTZ | | |

### authorities

| Spalte | Typ | Constraint |
|--------|-----|-----------|
| `id` | UUID | PK |
| `name` | VARCHAR | NOT NULL |
| `authority_type` | VARCHAR | |
| `jurisdiction_scope` | VARCHAR | |
| `jurisdiction_state` | VARCHAR | |
| `contact_info` | TEXT | |
| `created_at` | TIMESTAMPTZ | |
| `updated_at` | TIMESTAMPTZ | |

### source_evidence

| Spalte | Typ | Constraint | Beschreibung |
|--------|-----|-----------|---------|
| `id` | UUID | PK | |
| `case_id` | UUID | FK → cases | |
| `issue_id` | UUID | FK → issues (NULL) | |
| `url` | VARCHAR | NOT NULL | |
| `domain` | VARCHAR | | |
| `source_type` | VARCHAR | ENUM | OFFICIAL, LAW, AUTHORITY, etc. |
| `jurisdiction_scope` | VARCHAR | ENUM | FEDERAL, STATE, EU, etc. |
| `title` | TEXT | | |
| `evidence_excerpt` | TEXT | | |
| `claim_supported` | TEXT | | |
| `authority_score` | SMALLINT | 0-100 | |
| `relevance_score` | SMALLINT | 0-100 | |
| `jurisdiction_score` | SMALLINT | 0-100 | |
| `total_score` | SMALLINT | 0-100 | |
| `http_status` | SMALLINT | | z.B. 200, 404 |
| `checked_at` | TIMESTAMPTZ | | |
| `selected` | BOOLEAN | DEFAULT false | Vom User ausgewählt? |
| `text_full` | LONGTEXT | | Volltext für RAG |
| `text_path` | VARCHAR | | |
| `content_hash` | VARCHAR | UNIQUE per case+url | |
| `created_at` | TIMESTAMPTZ | | |
| `updated_at` | TIMESTAMPTZ | | |

### case_issue (Join-Tabelle)

| Spalte | Typ | Constraint |
|--------|-----|-----------|
| `case_id` | UUID | FK → cases, PK |
| `issue_id` | UUID | FK → issues, PK |
| `created_at` | TIMESTAMPTZ | |
| `updated_at` | TIMESTAMPTZ | |

### case_authority (Join-Tabelle)

| Spalte | Typ | Constraint |
|--------|-----|-----------|
| `case_id` | UUID | FK → cases, PK |
| `authority_id` | UUID | FK → authorities, PK |
| `created_at` | TIMESTAMPTZ | |
| `updated_at` | TIMESTAMPTZ | |

## Beziehungen

- `cases.wg_id` → `wgs.wg_id` (1:N)
- `cases.created_by_user_id` → `users.id` (N:1)
- `source_evidence.case_id` → `cases.case_id` (N:1)
- `source_evidence.issue_id` → `issues.id` (N:1, nullable)
- `case_issue.case_id` → `cases.case_id` (M:N via Join)
- `case_issue.issue_id` → `issues.id` (M:N via Join)
- `case_authority.case_id` → `cases.case_id` (M:N via Join)
- `case_authority.authority_id` → `authorities.id` (M:N via Join)

## ER-Diagramm (Aktueller Stand)

```mermaid
    USERS ||--o{ CASES : creates
    WGS ||--o{ CASES : has
    CASES ||--o{ CASE_ISSUE : contains
    CASES ||--o{ CASE_AUTHORITY : involves
    CASES ||--o{ SOURCE_EVIDENCE : contains
    ISSUES ||--o{ CASE_ISSUE : "referenced by"
    ISSUES ||--o{ SOURCE_EVIDENCE : "mentioned in"
    AUTHORITIES ||--o{ CASE_AUTHORITY : "assigned to"

    WGS {
        uuid wg_id PK
        string wg_name
        string state
        string governance
    }

    USERS {
        bigint id PK
        string name
        string email
        uuid active_wg_id FK
    }

    CASES {
        uuid case_id PK
        uuid wg_id FK
        bigint created_by_user_id FK
        string case_title
        string status
        text problem_description
        string priority
        text required_docs
        text next_actions
        text deadlines
        text source_links
        text attachments
        timestamptz last_reviewed_at
    }

    ISSUES {
        uuid id PK
        string code
        string name
        text description
        text default_authority_targets
        text default_required_docs
        text default_next_actions
        text default_source_links
    }

    AUTHORITIES {
        uuid id PK
        string name
        string authority_type
        string jurisdiction_scope
        string jurisdiction_state
    }

    SOURCE_EVIDENCE {
        uuid id PK
        uuid case_id FK
        uuid issue_id FK
        string url
        string domain
        string source_type
        string jurisdiction_scope
        text title
        text evidence_excerpt
        int authority_score
        int relevance_score
        int total_score
        boolean selected
        text text_full
    }

    CASE_ISSUE {
        uuid case_id FK
        uuid issue_id FK
    }

    CASE_AUTHORITY {
        uuid case_id FK
        uuid authority_id FK
    }
```

## n8n Integration – Direktzugriff auf PostgreSQL

+ Webhooks: n8n schreibt direkt in PostgreSQL Webhooks als backup

### Node-Konfiguration "Insert or update rows in a table"

**Für Cases:**
- **Schema:** `public`
- **Table:** `cases`
- **Match columns:** `case_id`
- **Mapping:** case_id, wg_id, created_by_user_id, case_title, status, problem_description, priority, required_docs, next_actions, deadlines, source_links, attachments

**Für Issues-Zuordnung (nach Case-Insert):**
- **Schema:** `public`
- **Table:** `case_issue`
- **Match columns:** `case_id`, `issue_id`
- **Insert:** `{ "case_id": "...", "issue_id": "..." }`

**Für Evidence:**
- **Schema:** `public`
- **Table:** `source_evidence`
- **Match columns:** `case_id`, `url`
- **Mapping:** case_id, issue_id, url, domain, source_type, jurisdiction_scope, title, evidence_excerpt, authority_score, relevance_score, jurisdiction_score, total_score, selected, text_full

### Postgres Credentials in n8n

```
Host: (dein n8n Netzwerk zu Postgres, z.B. postgres oder hostname)
Port: 5432
Database: laravel
User: vitakiez
Password: [DB_PASSWORD aus .env]
```
