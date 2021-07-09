const sharedConfig = require("./webpack.shared.config");

module.exports = {
  ...sharedConfig,
  mode: "development",
  devtool: 'inline-source-map',
  devServer: {
    port: 3000,
    watchContentBase: true,
    open: true,
    liveReload: true,
  },
}