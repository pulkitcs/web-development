const path = require("path");
const commonConfig = require("./webpack.common.config.js");

module.exports = ({
  ...commonConfig,
  devServer: {
    compress: true,
    port: 9000,
    liveReload: true,
    open: true,
  },
  mode: "development",
  devtool: "source-map",
})