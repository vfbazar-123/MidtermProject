# Account & Transaction Module - MyStore

## Overview

The Account and Transaction modules provide comprehensive financial management capabilities for MyStore, enabling you to track accounts, manage transactions, and monitor financial balances.

## Features

### Accounts
- **Create Accounts**: Set up new accounts with different types (Cash, Bank, Credit Card)
- **Account Management**: View, edit, and delete accounts
- **Balance Tracking**: Automatically updated balances based on transactions
- **Account Types**: Support for Cash, Bank, and Credit Card accounts
- **Status Management**: Active, Inactive, or Closed account statuses
- **Account Details**: View all transactions associated with each account

### Transactions
- **Create Transactions**: Record credit (deposits) and debit (withdrawals) transactions
- **Transaction Types**: Support for credit (income) and debit (expenses)
- **Transaction Tracking**: Track transactions by date, type, and status
- **Reference Numbers**: Optional reference numbers for tracking (e.g., check numbers, invoice IDs)
- **Transaction Status**: Pending, Completed, or Cancelled statuses
- **Automatic Balance Updates**: Account balances automatically update when transactions are created or modified
- **Transaction History**: View complete transaction history for each account

## Getting Started

### Database Setup
The migrations are automatically created and run:
- `2025_11_28_create_accounts_table.php` - Creates the accounts table
- `2025_11_28_create_transactions_table.php` - Creates the transactions table

### Sample Data
To populate the database with sample accounts and transactions, run:
```bash
php artisan db:seed --class=AccountSeeder
```

This will create:
- 3 sample accounts (Cash, Bank, Credit Card)
- 4 sample transactions across different accounts

## Navigation

### Main Menu Links
- **Accounts**: `/accounts` - View all accounts
- **Transactions**: `/transactions` - View all transactions

## Accounts Module

### Routes

| Method | Route | Name | Description |
|--------|-------|------|-------------|
| GET | `/accounts` | accounts.index | List all accounts |
| GET | `/accounts/create` | accounts.create | Create new account form |
| POST | `/accounts` | accounts.store | Store new account |
| GET | `/accounts/{account}` | accounts.show | View account details |
| GET | `/accounts/{account}/edit` | accounts.edit | Edit account form |
| PUT | `/accounts/{account}` | accounts.update | Update account |
| DELETE | `/accounts/{account}` | accounts.destroy | Delete account |

### Creating an Account
1. Click "New Account" button on the Accounts page
2. Fill in the following details:
   - **Account Number**: Unique identifier (e.g., ACC-001-CASH)
   - **Account Name**: Descriptive name (e.g., Main Cash Account)
   - **Account Type**: Select from Cash, Bank, or Credit Card
   - **Initial Balance**: Opening balance amount
   - **Status**: Active, Inactive, or Closed
   - **Description**: Optional notes

3. Click "Create Account" to save

### Editing an Account
1. View the account and click "Edit"
2. Modify the account details
3. Click "Update Account" to save changes

### Viewing Account Details
- Click on an account to view:
  - Account information (number, name, type, balance, status)
  - All transactions associated with the account
  - Option to add new transactions

## Transactions Module

### Routes

| Method | Route | Name | Description |
|--------|-------|------|-------------|
| GET | `/transactions` | transactions.index | List all transactions |
| GET | `/transactions/create` | transactions.create | Create new transaction form |
| POST | `/transactions` | transactions.store | Store new transaction |
| GET | `/transactions/{transaction}` | transactions.show | View transaction details |
| GET | `/transactions/{transaction}/edit` | transactions.edit | Edit transaction form |
| PUT | `/transactions/{transaction}` | transactions.update | Update transaction |
| DELETE | `/transactions/{transaction}` | transactions.destroy | Delete transaction |
| GET | `/accounts/{account}/transactions` | transactions.byAccount | View transactions for specific account |

### Creating a Transaction
1. Click "New Transaction" button on the Transactions page (or "Add Transaction" from an account)
2. Fill in the following details:
   - **Account**: Select the account to transaction against
   - **Transaction Type**: Select Credit (deposit) or Debit (withdrawal)
   - **Amount**: Transaction amount
   - **Transaction Date**: Date of the transaction
   - **Reference Number**: Optional (e.g., check number, invoice ID)
   - **Description**: Transaction details
   - **Status**: Pending, Completed, or Cancelled

3. Click "Create Transaction" to save

**Note**: When a transaction is created:
- Credit transactions add to the account balance
- Debit transactions subtract from the account balance

### Editing a Transaction
1. Click on a transaction to view details
2. Click "Edit" button
3. Modify transaction details
4. Click "Update Transaction" to save changes

**Important**: Completed and cancelled transactions cannot be edited. You must delete and recreate them if needed.

### Deleting a Transaction
1. View the transaction details
2. Click "Delete Transaction" button
3. Confirm the deletion

**Note**: When a transaction is deleted:
- The account balance is automatically reverted
- The transaction amount is removed from the account balance

## Model Relationships

### Account Model
```php
// Get transactions for an account
$account->transactions;

// Get total debit amount
$account->getTotalDebit();

// Get total credit amount
$account->getTotalCredit();
```

### Transaction Model
```php
// Get the account for a transaction
$transaction->account;
```

## Data Validation

### Account Validation Rules
- Account Number: Required, unique, string
- Account Name: Required, max 255 characters
- Account Type: Required, must be one of: Cash, Bank, Credit Card
- Balance: Required, numeric, minimum 0
- Status: Required, must be one of: active, inactive, closed
- Description: Optional, string

### Transaction Validation Rules
- Account ID: Required, must exist in accounts table
- Transaction Type: Required, must be debit or credit
- Amount: Required, numeric, minimum 0.01
- Description: Optional, max 1000 characters
- Reference Number: Optional, unique string
- Transaction Date: Required, valid date
- Status: Required, must be one of: pending, completed, cancelled

## Best Practices

1. **Always Verify Balances**: Review account balances regularly to ensure they match your records
2. **Use Reference Numbers**: Include reference numbers for traceability (check numbers, invoice IDs, etc.)
3. **Complete Descriptions**: Add clear descriptions for transactions to facilitate auditing
4. **Status Management**: Mark transactions as "Pending" until confirmed, then update to "Completed"
5. **Regular Reconciliation**: Compare system balances with bank statements and cash counts monthly
6. **Don't Delete**: Instead of deleting transactions, mark them as "Cancelled" for audit trails

## Database Tables

### accounts table
```sql
CREATE TABLE accounts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    account_number VARCHAR(255) UNIQUE NOT NULL,
    account_name VARCHAR(255) NOT NULL,
    account_type VARCHAR(255) NOT NULL,
    balance DECIMAL(15,2) DEFAULT 0,
    status ENUM('active','inactive','closed') DEFAULT 'active',
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (account_number),
    INDEX (status)
);
```

### transactions table
```sql
CREATE TABLE transactions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    account_id BIGINT NOT NULL,
    transaction_type ENUM('debit','credit') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    description TEXT NULL,
    reference_number VARCHAR(255) UNIQUE NULL,
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','completed','cancelled') DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES accounts(id) ON DELETE CASCADE,
    INDEX (account_id),
    INDEX (transaction_type),
    INDEX (transaction_date),
    INDEX (status)
);
```

## Troubleshooting

### Issue: Cannot delete account with transactions
**Solution**: Delete all transactions associated with the account first, or mark them as cancelled instead

### Issue: Transaction balance doesn't match manual calculation
**Solution**: Verify all transactions are marked as "completed" status. Pending transactions may not be reflected in calculations.

### Issue: Edit button not available for transaction
**Solution**: Completed and cancelled transactions are locked. Create a new transaction or delete and recreate if needed.

## Support & Maintenance

For issues or questions:
1. Check the database directly: `SELECT * FROM accounts;` and `SELECT * FROM transactions;`
2. Review transaction logs in `/storage/logs/`
3. Verify database migrations ran successfully: `php artisan migrate:status`

---

**Last Updated**: November 28, 2025
