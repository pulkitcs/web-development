const commonConfig = require("./webpack.common.config.js");

module.exports = ({
  ...commonConfig,
  mode: "production",
})