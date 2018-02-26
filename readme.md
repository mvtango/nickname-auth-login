# nickname-auth-login 

```
Contributors: mvtango
Tags: wordpress, plugin, login
Requires at least: 4.8
Tested up to: 4.8
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
```

Allow users to authenticate with their nicknames + passwords. THIS CAN BE A SECURITY NIGHTMARE. Consider carefully before enabling.

## Description 

After activating this plugin, users can authenticate using their nickname and password as an alternative to username and password.
. 
Nicknames updates that would result in duplicate nicknames will be refused after activation of the plugin.

Known Bugs: 

  - The plugin will not check for existing duplicate nicknames on installation. 
  - If duplicate nicknames exist, the plugins refuses to use them for authentication



Tip:

Use this SQL query to list the users with duplicate nicknames: 

```sql

select 
    count(*) as count, 
    group_concat(wp_users.user_login), 
    group_concat(wp_users.ID), meta_value 
from wp_usermeta, wp_users 
where 
    meta_key="nickname" 
   and wp_usermeta.user_id=wp_users.ID 
group by meta_value 
having count>1;

```

## Installation 

Installing the plugin can be done by downloading the .zip file from here:

https://github.com/mvtango/nickname-auth-login/archive/master.zip

... and uploading it through the 'Plugins > Add New > Upload' screen in your WordPress dashboard. 
Then activate the plugin through the 'Plugins' menu in WordPress.


