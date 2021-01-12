const path = require('path');
const vendorUiPath = path.resolve(__dirname, 'vendor/monofony/ui-bundle');
const build = require('./src/Monofony/Pack/CorePack/.recipe/config-builder');

const backendConfig = build('backend', `./src/Monofony/Pack/AdminPack/.recipe/assets/backend/`, vendorUiPath);
const frontendConfig = build('frontend', `./src/Monofony/Pack/FrontPack/.recipe/assets/frontend/`, vendorUiPath);

module.exports = [backendConfig, frontendConfig];
