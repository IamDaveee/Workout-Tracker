-- Migration: Add appwrite_id column to users table for OAuth integration
-- Date: 2025-12-06
-- Description: Adds appwrite_id column to store Google OAuth user identifiers

ALTER TABLE users ADD COLUMN appwrite_id VARCHAR(255) NULL UNIQUE;

-- Create index on appwrite_id for faster lookups during OAuth login
CREATE INDEX idx_users_appwrite_id ON users(appwrite_id);
