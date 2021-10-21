const path = require("path");
const commonConfig = require("./webpack.common.config.js");

module.exports = ({
  ...commonConfig,
  devServer: {
    contentBase: path.join(__dirname, 'public'),
    compress: true,
    port: 9000,
    liveReload: true,
    open: true,
  },
  mode: "development",
  devtool: "source-map",
})