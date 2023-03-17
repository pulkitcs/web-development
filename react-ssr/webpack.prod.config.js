import sharedConfig from "./webpack.shared.config.js";

const config = {
  ...sharedConfig,
  mode: "production",
};

export default config;
