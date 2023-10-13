const Encore = require(
        '@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(
            process.env.NODE_ENV ||
            'dev');
}

Encore
        .addEntry(
                'app',
                './resources/app.js')
        .cleanupOutputBeforeBuild()
        .disableSingleRuntimeChunk()
        .enableSassLoader()
        .enableSourceMaps(
                !Encore.isProduction())
        .enableVersioning(
                true)
        .copyFiles(
                [
                    {
                        from: 'resources/images/',
                        to: './images/[path][name].[ext]'
                    }
                ]
        )
        .setOutputPath(
                '../../web/app/themes/theme/public')
        .setPublicPath(
                '/app/themes/theme/public');

module.exports = Encore.getWebpackConfig();
