# Symfony_Foundation_Blogging_App_Example

```
project_root/
├── composer.json
├── src/
│   ├── Service/
│   │   └── FileUploader.php
│   ├── Controller/
│   │   ├── Admin/
|   |   |   └── AdminHomePageController.php
│   │   ├── User/
│   │   |    ├── HomePageController.php
│   │   |    ├── BlogPageController.php
│   │   |    └── BlogPostPageController.php
|   |   ├── LoginController.php
|   |   └── LogoutController.php
│   ├── Entity/
│   │   ├── Users.php
│   │   ├── BlogPosts.php
│   │   └── PostComments.php
│   ├── Repository/
│   │   ├── UsersRepository.php
│   │   ├── BlogPostsRepository.php
│   │   └── PostCommentsRepository.php
├── templates/
|    ├──layouts/
|    |   └── main-layout.html.twig
|    └── pages/   
|        ├── admin-home-page.html.twig
|        ├── home-page.html.twig
|        ├── blog-page.html.twig
|        ├── blog-post-page.html.twig
|        └── plog-post-page-add.html.twig
├── public/
|   ├──layouts/
|   |   └── main-layout.html.twig
.   ├── assets/   
.   |   ├── css/
.   |   |   └── main.css
    |   ├── js/
    |   |   └── app.js
    |   └── img/ -- default or app images
    └── uploads/
        └── posts/ -- posts images 
   ...      
```
