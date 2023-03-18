const sharedConfig = require("./webpack.shared.config");

module.exports = {
  ...sharedConfig,
  mode: "production",
  output: {
    filename: "js/bundle.js",
    path: path.resolve("dist"),
    assetModuleFilename: 'assets/[hash][ext][query]',
    library: {
      name: 'clientApp',
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