<?php

namespace App\Utilities;

class Constants
{
    const DEFAULT_PAGINATION = 10;
    const ADMIN_CHARGE_AMOUNT = 0.1;
    const PARTIAL_PAYMENT_PERCENTAGE = 0.1;

    const EMAIL_SUBJECT = [
        'opt_send' => 'Send OTP',
        'contact-us' => 'Contact Us',
        'email-notification' => 'Email Notification',
    ];

    const EMAIL_RECEIVER = 'moeenkhan028@gmail.com';

    const USER_ROLE = [
        'user' => 0,
        'pro' => 1, //driver
    ];

    const ACCOUNT_STATUS = [
        'active' => 1,
        'deactive' => 2,
        'blocked' => 3,
    ];

    const MESSAGES = [
        'signup_success' => 'User registered successfully.',
        'generic_error' => 'Something went wrong try again later.',
        'login_success' => 'Logged in Successfully.',
        'verify_success' => 'Verified Successfully',
        'already_verified' => 'Already Verified',
        'social_login_success' => 'User social logged in/signed up successfully.',
        'logout_success' => 'Logged out Successfully.',
        'sent_otp' => 'Otp code has been sent, please check your email.',
        'otp_verify' => 'Otp code is verfied successfully.',
        'login_error' => 'Email or Password is incorrect.',
        'reset_password' => 'Password has been reset successfully.',
        'update_profile' => 'Profile has been updated successfully.',
        'create_profile' => 'Profile created successfully.',
        'get_profile' => 'Get profile successfully.',
        'update_profile_image' => 'Updated profile image successfully.',
        'delete_profile_iamge' => 'Image deleted successfully',
        'password_updated' => 'Password updated successfully.',
        'blocked_user' => 'User blocked successfully!',
        'unblocked_user' => 'User unblocked successfully!',
        'success' => 'Success!',
        'not_found' => 'User not found!',
        'success' => 'Successfully!',
        'cover_image_updated' => 'Cover image has been updated successfully.',
        'reported_successfully' => 'Reported successfull!',
        'update_social_links' => 'Social links has been update successfully.',
        'submit_contact_form' => 'Contact form submitted successfully.',
        'newsletter_subscribed' => 'Newsletter subscribed successfully.',
        'newsletters_list' => 'Newsletters list got successfully.',
        'already_subscribed_newsletter' => 'Already subscribed newsletter.',
        'notifications_list' => 'Notifications list got successfully.',
        'notifications_count' => 'Notifications count got successfully.',
        'transaction_added' => 'Transaction added.',
        'contacts_list' => 'Contacts list got successfully.',
        'set_working_hours' => 'Working hours set successfully.',
        'legal_documents_uploaded' => 'Legal documents uploaded successfully.',
        'service_deleted' => 'Service has been deleted successfully.',
    ];

    const SERVICE_STATUS = [
        'active' => 1,
        'blocked' => 2,
        'suspend' => 3,
    ];

    const TASK_STATUS = [
        'pending' => 0,
        'budget_pending' => 7,
        'done' => 1,
        'in_process' => 2,
        'accept' => 3,
        'completed' => 4,
        'reject' => 5,
        'paid' => 6
    ];

    const TERMS = [
        '0' => 'Terms & Condition',
        '1' => 'Privacy Policy',
    ];

    const BLOG_PATH = 'assets/blogs';
    const BLOG_PATH_PREFIX = 'blog-';

    const CATEGORY_PATH = 'assets/categories';
    const CATEGORY_PATH_PREFIX = 'category-';

    const PLANS = [
        0 => 'Monthly Plan',
        1 => 'Annual Plan'
    ];

    const PLANS_INTERVAL = [
        0 => 1,
        1 => 12
    ];

    const EXPERIENCE_YEARS = [
        0 => '<1',
        1 => '1-3',
        2 => '3-5',
        3 => '5-8',
        4 => '8+'
    ];

    // Notifiation

    const NOTIFICATION_MESSAGE_PLACEHOLDER = [
        '0' => 'TASK_TITLE',
    ];

    const NOTIFICATION_MESSAGE = [
        '0' => 'Lead [[TASK_TITLE]] has been created.',
        '1' => 'Lead [[TASK_TITLE]] has been rejected.',
        '2' => '[[TASK_TITLE]] has been approved.',
        '3' => '[[TASK_TITLE]] has been executed and in done state.',
        '4' => '[[TASK_TITLE]] has been completed.',
        '5' => 'Your task [[TASK_TITLE]] has been rescheduled.',
        '6' => 'Your task [[TASK_TITLE]] price has been updated.',
        '7' => 'Your task [[TASK_TITLE]] has been assigned to [[PRO_NAME]].',
        '8' => '[[PRO_NAME]] has sent you a service request.',
        '9' => 'Your send bid request has been accepted by [[USER_NAME]].',
        '10' => 'Your send request has been rejected by [[PRO_NAME]].',
        '11' => 'Payment of task [[TASK_TITLE]] has been sent.',
    ];

    const NOTIFICATION_TYPE = [
        0 => 'Send Request.',
        2 => 'Accept Request',
        1 => 'Task approval.',
        3 => 'Task done.',
        4 => 'Task completion.',
        5 => 'Task scheduling',
        6 => 'Task price updation',
        7 => 'Task assign',
        8 => 'Chat message',
        9 => 'Task Expired',
        10 => 'payment paid',
        11 => 'Reject Request',
    ];

    const SKIP_COOLDOWN_TIME_AMOUNT = 4;
    const FREE_TRIAL_DAYS = 7;

    const PAYMENT_STATUS = [
        1 => 'upfront_payment',
        2 => 'full payment',
        3 => 'pending'
    ];
}
