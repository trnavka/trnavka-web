<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="d9135c82-8787-4c6a-9dcd-c53b31e191a4" data-blockingmode="auto" type="text/javascript"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-HH2X1377G8"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'G-HH2X1377G8');
        </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <?php do_action('get_header'); ?>

        <div id="app">
            <?php echo view(app('sage.view'), app('sage.data'))->render(); ?>
        </div>

        <?php do_action('get_footer'); ?>
        <?php wp_footer(); ?>
    </body>
</html>
