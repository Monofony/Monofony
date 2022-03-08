const path = require('path');
const vendorUiPath = path.resolve(__dirname, 'vendor/sylius/ui-bundle');
const build = require('./src/Monofony/MetaPack/CoreMeta/.recipe/config-builder');

const backendConfig = build('backend', `./src/Monofony/MetaPack/AdminMeta/.recipe/assets/backend/`, vendorUiPath);
const frontendConfig = build('frontend', `./src/Monofony/MetaPack/FrontMeta/.recipe/assets/frontend/`, vendorUiPath);

module.exports = [backendConfig, frontendConfig];
