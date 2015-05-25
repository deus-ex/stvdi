<?php

  $lang = array();

  // Language file details
  $lang['suffix'] = 'en-us';
  $lang['title'] = 'English (US)';
  $lang['desc'] = 'Native Language of the United State of America';
  $lang['modified'] = '2015-05-24 01:05:30';
  $lang['author'] = 'Jay';

  // Login 

	$lang	= array(



    // Login
    'invalid_submission'  => 'Invalid Form Submission.',
    'invalid_data'  => 'Invalid Username/Password.',
    'terminate_time'  => 'You can\'t login at this time.',
    'invalid_user_pass'  => 'Invalid Username/Password.',
    'account_suspended'  => 'This account has been suspended. Please contact the system administrator for assistance.',
    'no_login_access'  => 'This account doesn\'t have login access at this time. Please contact the system administrator for assistance.',
    'already_logged_in'  => 'This account has been logged in on another system.',
    'logout_success'  => 'You have been successfully logged out.',
    'logout_reset'  => 'You have been automatically logged out due to a change in your password. Please login with the new password.',

    // Users
    'no_user_loaded'  => 'Invalid Data Submission.',
    'user_already_active'  => 'Invalid Data Submission.',

    // Password
    'password_match'  => 'Passwords do not match.',
    'password_changed'  => 'Password has been updated.',
    'invalid_db_password'  => 'Invalid Password, please re-enter the correct password.',

    // Authentication Code for Password Reset
    'email_not_sent'  => 'Internal server error. Please try again later.',
    'password_reset_sent'  => 'To reset your password, follow the instructions in the email we\'ve just sent you from <b>{admin-email}</b>.',
    'invalid_auth_code'  => 'Sorry! This password reset link is invalid!.',

    // Empty Values
    'empty_field'  => 'Please enter {value}.',
    'empty_user_pass'  => 'Please enter your username/password.',
    'empty_password'  => 'Enter a Password.',
    'empty_old_password'  => 'Enter a Old Password.',
    'empty_new_password'  => 'Enter a New Password.',
    'empty_confirm_password'  => 'Enter a Confirm Password.',
    'empty_username'  => 'Enter a Username.',
    'empty_firstname'  => 'Enter User First Name.',
    'empty_lastname'  => 'Enter User Last Name.',
    'empty_branch'  => 'Enter/Select a branch.',
    'empty_privilege'  => 'Select user privilege.',
    'empty_email'  => 'Enter a valid Email Address.',
    'empty_code'  => 'Please enter Card Number.',
    'empty_verify_type'  => 'Enter/Select verification type.',

    // Email
    'invalid_email'  => 'Invalid Email Address.',
    'email_not_found'  => 'Unable to locate a user with this email address.',
    'user_not_found'  => 'Unable to locate a user with this username.',
    'email_exist'  => 'Email Address Exist.',

    // System
    'character_min_length'  => 'Input must be a minimum of {count} characters.',
    'character_max_length'  => 'Input must be a maximum of {count} characters.',
    'internal_db_update_error'  => 'Invalid Data Submission.',
    'internal_error'  => 'Unable to perform this operation. Please try again later.',
    'empty_list_header'  => 'No {list-title} added yet.',
    'empty_list_desc'  => 'Please click the \'Add {btn-name}\' button above to add a {btn-name}.',

    // Merchant/Branch
    'empty_merchant_cat'  => 'Enter/Select a Category.',
    'empty_merchant_name'  => 'Enter Merchant Name.',
    'empty_merchant_uname'  => 'Enter a Unique Name.',
    'invalid_uname_character'  => 'Invalid characters, it must contain alphabet or numeric or alphanumeric characters.',
    'empty_merchant_web'  => 'Enter Merchant Website.',
    // 'merchant_added'  => 'Merchant details has been added successfully.',
    // 'merchant_updated'  => 'Merchant details has been updated successfully.',
    'merchant_uname_changed'  => 'Unique Name has been changed successfully.',
    'merchant_logo_changed'  => 'Merchant logo has been uploaded successfully.',
    // 'merchant_deleted'  => 'Merchant details has been deleted successfully.',
    // 'delete_merchant'  => 'Are you sure you want to permanently remove {delete-item} and all its details from the system?.',
    // 'merchant_status_active'  => 'You have successfully activated {merchant-name} and all its service.',
    // 'merchant_status_inactive'  => 'You have successfully deactivated {merchant-name} and all its service.',
    // 'category_added'  => '"{value}" has been added to the system successfully.',
    // 'category_updated'  => '"{value}" has been updated to the system successfully.',
    'not_added'  => 'Unable to add "{name}" at this time, please try again later.',

    // Active
    'status_active'  => 'You have successfully activated <strong>{name}</strong> and all its service.',
    'status_inactive'  => 'You have successfully deactivated <strong>{name}</strong> and all its service.',

    'empty_branch_name'  => 'Enter Branch Name.',
    'empty_branch_add'  => 'Enter Branch address.',
    'empty_branch_city'  => 'Enter Branch city.',
    'empty_branch_state'  => 'Enter Branch state.',
    'empty_branch_country'  => 'Enter/Select Branch country.',
    'empty_branch_email'  => 'Enter Branch email address.',
    'empty_branch_phone'  => 'Enter Branch phone number.',
    'empty_branch_currency'  => 'Enter/select currency.',
    // 'branch_added'  => 'Branch has been added successfully.',
    // 'branch_updated'  => 'Branch has been updated successfully.',
    // 'branch_deleted'  => 'Branch has been deleted successfully.',
    // 'delete_branch'  => 'Are you sure you want to permanently remove {delete-item} branch and all its details from the system?.',
    // 'branch_status_active'  => 'You have successfully activated {branch-name} branch and all its service.',
    // 'branch_status_inactive'  => 'You have successfully deactivated {branch-name} branch and all its service.',

    // Merchant User
    // 'user_added'  => '<strong>{name}</strong> has been added successfully.',
    // 'user_updated'  => '<strong>{name}</strong> details has been updated successfully.',
    // 'user_deleted'  => 'User has been deleted successfully.',
    // 'delete_user'  => 'Are you sure you want to permanently remove "<strong>{name}</strong>" and all its details from the system?.',
    // 'user_status_active'  => 'You have successfully granted <strong>{name}</strong> login access.',
    // 'user_status_inactive'  => 'You have successfully revoked <strong>{name}</strong> login access.',

    // Branch Tax
    // 'tax_added'  => '<strong>{name}</strong> has been added successfully.',
    // 'tax_updated'  => '<strong>{name}</strong> details has been updated successfully.',
    // 'tax_deleted'  => 'Tax has been deleted successfully.',
    // 'delete_tax'  => 'Are you sure you want to permanently remove <strong>{delete-item}</strong> and all its details from the system?.',

    // Message
    'added'  => '<strong>{name}</strong> has been added successfully.',
    'updated'  => '<strong>{name}</strong> details has been updated successfully.',
    'deleted'  => '<strong>{name}</strong> has been deleted successfully.',

    // Search
    'search_not_found'  => 'Oops! Search "{search}" not found.',
    'search_again'  => 'Please try to search for another keyword, you just might be lucky.',

    // Check Availability
    'available'  => '"{value}" is available.',
    'not_available'  => '"{value}" is already taken. Please try another one.',
    'empty_parameters'  => 'Please check your datas some parameters are missing.',

    // Warning
    'delete'  => 'Are you sure you want to permanently remove <strong>{name}</strong> and all its details from the system?.',

    // Notification
    'change_password'  => 'You need to change your password. Please click <a href="{link}" class="popup" data-width="400" data-height="390">here</a> to change your password.',
    'bank_update'  => 'You can\'t accept any gift card at the moment because your Bank Account has not been setup, please click <a href="{link}" class="popup" data-width="400" data-height="400">here</a> to setup your account.',

    // Gift Kard / Payment
    'invalid_card'  => 'Invalid Card Details.',
    'invalid_amount'  => 'Invalid Amount.',
    'invalid_date'  => 'Invalid Date.',
    'is_not_numeric'  => 'Invalid value, please enter a numeric value.',
    'empty_amount'  => 'Enter an Amount.',
    'empty_code'  => 'Enter Card Number.',
    'empty_pin'  => 'Enter Card PIN.',
    'valid_card'  => 'Card is valid.',
    'card_expired'  => 'Card has expired.',
    'card_empty'  => 'Card has no funds.',
    'insufficient_fund'  => 'Insufficient Funds.',
    'card_inactive'  => 'Card has been deactivated.',
    'transaction_successful'  => 'Transaction successful. Gift Kard has been charged.',
    '* add_kard_successful'  => 'Gift Kard has been added successfully.',

    // Gift Kard Verification
    'card_balance'  => 'Card Balance is <strong>{value}</strong>.',
    'card_expire'  => 'Card expires on <strong>{value}</strong>',
    'card_expired'  => 'Card expired in <strong>{value}</strong>',
    'card_active'  => 'Card is active',

    // File Upload
    'file_not_found'  => 'Please select a file.',
    'file_not_saved'  => 'Unable to save file. Please try again later.',
    'invalid_file'  => 'is an invalid file.',
    'file_size_error'  => 'Can not display file size.',
    'invalid_size'  => 'size must be less than {value}.',
    'uploaded'  => 'has been uploaded successfully.',

    // Settings
    'invalid_pagelist'  => 'Invalid Page List value. It must be a numeric value.',
    'pagelist_updated'  => 'Page List Updated.',
    'landingpage_updated'  => 'Landing Page Updated.',
    'language_updated'  => 'Language Updated.',
    'currency_updated'  => 'Currency Updated.',
    'card_prefix_updated'  => 'Card Prefix Updated.',
    'card_digit_updated'  => 'Card Digit Count Updated.',
    'time_updated'  => 'Time format Updated.',
    'date_updated'  => 'Date format Updated.',
    'reset_uniquename'  => 'Unique name reset was successful.',
    'card_expire_updated'  => 'Card Expiration Updated.',
    'card_alert_updated'  => 'Card Payment Alert Updated.',
    'card_serial_updated'  => 'Card Serial Settings Updated.',
    'login_attempt_updated'  => 'Login attempts Updated.',
    'settings_updated' => 'System settings updated.',
    'login_time_updated'  => 'Login Time Out Updated.',
    'login_period_updated'  => 'Login Period Updated.',
    'bank_details_updated'  => 'Bank Account Details Updated.',
    'empty_input'  => 'Please enter a value.',
    'empty_list_input'  => 'Please enter/select a value from list.',
    'empty_landingpage'  => 'Please enter/select a value from list.',
    'empty_language'  => 'Please enter/select a value from list.',
    'empty_currency'  => 'Please enter/select a value from list.',
    'prefix_length'  => 'Please card prefix should be a minimum of 3 and a maximum 4 characters.',
    'invalid_prefix'  => 'Invalid prefix. It must be alphabet only.',

    // Gateway response
    'deposit_successful'  => '{amount} has been deposited successfully',
    //Voguepay
    'voguepay_account'  => 'Bank account not registered.',
    'voguepay_process'  => 'Unable to process command. Please try again later.',

    // Fetch
    'X001'  => 'Invalid Merchant ID.',
    'X002'  => 'Invalid Reference.',
    'X003'  => 'Invalid Security Code.',
    'X004'  => '8004 Internal error<br />There was an error processing your request. Contact technical support for assistance.',

    'X005'  => 'Invalid Merchant ID.',
    'X006'  => 'Invalid Security Code.',

    // Create
    'C001'  => 'Unauthorised access.',
    'C002'  => 'Invalid email address.',
    'C003'  => 'Invalid username.',
    'C004'  => 'Invalid phone number.',
    'C005'  => 'Invalid firstname.',
    'C006'  => 'Invalid lastname.',
    'C007'  => 'Invalid country.',
    'C008'  => 'Unable to create member.',
    'C009'  => 'Unable to create member.',

    // Withdraw
    'W001'  => 'Invalid amount. Contact technical support for assistance.',
    'W002'  => '1002 Internal error<br />There was an error processing your request. Contact technical support for assistance.',
    'W003'  => 'Deposit amount is below minimum allowed <strong>{amount}</strong>.',
    'W004'  => '1004 Internal error<br />There was an error processing your request. Contact technical support for assistance.',
    'W005'  => '1005 Internal error<br />There was an error processing your request. Contact technical support for assistance.',
    'W006'  => '1006 Internal error<br />There was an error processing your request. Contact technical support for assistance.',

    // Pay
    'P001'  => 'Invalid amount.',
    'P002'  => '1102 Internal error<br />There was an error processing your request. Contact technical support for assistance.',
    'P003'  => 'Seller and buyer are one and the same.',
    'P004'  => 'Invalid beneficiary.',
    'P005'  => 'Invalid memo.',
    'P006'  => 'Payment amount is below minimum allowed.',
    'P007'  => 'Payment amount exceeds maximum allowed.',
    'P008'  => 'Insufficient balance for payment.',
    'P009'  => 'Payment failed.',
    'P010'  => 'Payment failed.',
    'P011'  => 'Payment failed.',

	);

?>