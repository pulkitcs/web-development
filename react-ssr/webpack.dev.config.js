import sharedConfig from "./webpack.shared.config.js";

const config = {
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

export default config;