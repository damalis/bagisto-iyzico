const { mix } = require("laravel-mix");
require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = 'publishable/assets';
} else {
    var publicPath = "../../../public/vendor/damalis/iyzico/assets";
}


mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

    mix.copy(__dirname + "/src/Resources/assets/images", publicPath + "/images/");

if (mix.inProduction()) {
    mix.version();
}