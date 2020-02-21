const path = require('path');
const vendorUiPath = path.resolve(__dirname, 'vendor/sylius/ui-bundle');
const build = require('./src/CorePack/recipe/config-builder');

const backendConfig = build('backend', `./src/AdminPack/recipe/assets/backend/js/app.js`, vendorUiPath);
const frontendConfig = build('frontend', `./src/FrontPack/recipe/assets/frontend/js/app.js`, vendorUiPath);

module.exports = [backendConfig, frontendConfig];
