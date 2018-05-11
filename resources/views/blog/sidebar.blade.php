<aside class="col-md-4 blog-sidebar">
    <div class="p-3 mb-3 bg-light rounded">
        <h4 class="font-italic">About</h4>
        <p class="mb-0">
            <strong>Welcome.</strong> This site is built using Laravel, Vuejs, and Bootstrap 4 and is simply full of
            dummy data for now to demonstrate functionality.
            <br>
            You can check out more by logging in as the <strong>demo user:</strong>
            <br><br>
            <strong>email:</strong> demouser@nathanhaley.com
            <br>
            <strong>password:</strong> pass123
            <br><br>
            Please feel free to submit a comment and edit it, create a post and edit it, follow/unfollow another user,
            like/unlike a comment/post/auther. And more.
            <br><br>
            <strong>Note:</strong> You can create an account from scratch but this is basically a live site and you will
            need to validate your email before being able to add posts or comments.
        </p>
    </div>

    @include('posts.archives-menu')

    <div class="p-3">
        <h4 class="font-italic">Elsewhere</h4>
        <ol class="list-unstyled">
            <li><a href="https://github.com/NathanHaley/laravel_blog_1">GitHub</a></li>
        </ol>
    </div>
</aside><!-- /.blog-sidebar -->