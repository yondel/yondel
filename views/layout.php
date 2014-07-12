<!doctype html>
<html lang="ja">
<head>
<title><?php if (isset($title)) : echo $this->escape($title) . ' - '; endif; ?>yondel</title>
</head>
<body>
<header>
<h1><a href="<?php echo $base_url; ?>">yondel</a></h1>
</header>
<section>
<?php echo $_content; ?>
</section>
<footer>
<p>&copy;<?php echo date('Y') ?> yondel, All rights reserved.</p>
</footer>
</body>
</html>
