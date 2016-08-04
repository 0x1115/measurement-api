<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Setup</title>
	<link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <main class="wrapper">
        <section class="container">
            <form role="form" method="POST" action="<?php echo route('web.setup')?>">
                <?php if (isset($errors)): ?>
                <section class="clearfix">
                    <?php foreach($errors as $error): ?>
                    <pre><code><?php echo $error;?></code></pre>
                    <?php endforeach; ?>
                </section>
                <?php endif; ?>
                <fieldset>
                    <label for="email">Email</label>
                    <input type="email" placeholder="user@domain.com" id="email" name="email" value="<?php echo isset($data['email']) ? $data['email'] : ''?>">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <input class="button-primary" type="submit" value="Setup">
                </fieldset>
            </form>
        </section>
    </main>
</body>
</html>