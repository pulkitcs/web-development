const sharedConfig = require("./webpack.shared.config");

module.exports = {
  ...sharedConfig,
  mode: "production",
}