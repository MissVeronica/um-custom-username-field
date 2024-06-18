# UM Extra Custom Username Field
Extension to Ultimate Member for selecting an extra Registration Custom field for Login.

## UM Settings -> Appearance -> Registration Form
1. UM meta_key - UM meta_key name to be used as an extra Username field for Login. Examples: um_unique_membership_id or um_unique_account_id
2. WP Users fields user_nicename, display_name

## UM Forms Builder -> Login form
1. Use the predefined Form field "Username or email" with the meta_key "username" for Login User identification.
2. Users can be identified by both Username, Email address and the UM meta_key value or WP Users field value.
3. Add the additional Custom User field or WP Users fields for identification in the Label.

## UM Email
1. Use the Email placeholder {usermeta:here_any_usermeta_key}
2. https://docs.ultimatemember.com/article/1340-placeholders-for-email-templates

## Error messages
1. There are more than one user registered with this %s

## Translations or Text changes
1. Use the "Say What?" plugin with text domain ultimate-member
2. https://wordpress.org/plugins/say-what/

## Updates
1. Version 1.0.0
2. Version 1.1.0 Tested with UM 2.8.6
3. Version 1.2.0 Code improvements by identification both Username, Email address and the UM metas_key value
4. Version 1.3.0 Addition of the WP Users fields: user_nicename, display_name

## References
1. Unique User Account ID - https://github.com/MissVeronica/um-unique-user-account-id
2. Unique Membership ID - https://github.com/MissVeronica/um-unique-membership-id

## Installation
1. Download the ZIP file and install as a WP Plugin.
2. Activate the plugin.

