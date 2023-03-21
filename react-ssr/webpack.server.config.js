const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const path = require("path");

const sharedConfig = require("./webpack.shared.config");

module.exports = {
  ...sharedConfig,
  entry: "./src/app/App.tsx",
  mode: "production",
  devtool: false,
  output: {
    filename: "js/bundle-server.js",
    path: path.resolve("dist"),
    assetModuleFilename: 'assets/[hash][ext][query]',

    library: {
      name: 'serverApp',
      type: "commonjs-module"
    }
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "css/[name].css",
      chunkFilename: "css/[id].css",
    }),
  ],
};