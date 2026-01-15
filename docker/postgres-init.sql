-- Create the vitakiez user if it doesn't exist
CREATE USER vitakiez
WITH
    PASSWORD 'ULUCUYXV7U2jXnYgDGCxEeGUHCdqzZUM';

-- Create the laravel database
CREATE DATABASE laravel OWNER vitakiez;

-- Grant privileges to vitakiez user
GRANT CONNECT ON DATABASE laravel TO vitakiez;

GRANT USAGE ON SCHEMA public TO vitakiez;

GRANT CREATE ON SCHEMA public TO vitakiez;

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO vitakiez;

GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO vitakiez;

ALTER DEFAULT PRIVILEGES IN SCHEMA public
GRANT ALL PRIVILEGES ON TABLES TO vitakiez;

ALTER DEFAULT PRIVILEGES IN SCHEMA public
GRANT ALL PRIVILEGES ON SEQUENCES TO vitakiez;