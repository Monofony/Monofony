const path = require('path');
const vendorUiPath = path.resolve(__dirname, 'vendor/sylius/ui-bundle');
const build = require('./src/Monofony/Bundle/CoreBundle/Recipe/config-builder');

const backendConfig = build('backend', `./src/Monofony/Bundle/AdminBundle/Recipe/assets/backend/`, vendorUiPath);
const frontendConfig = build('frontend', `./src/Monofony/Bundle/FrontBundle/Recipe/assets/frontend/`, vendorUiPath);

module.exports = [backendConfig, frontendConfig];
