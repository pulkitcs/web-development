const path = require("path");
//const HtmlWebpackPlugin = require("html-webpack-plugin");
const webpackEntries = require("./webpack.entries.js");
const webpack = require("webpack");

// for creating dynamic pages
// const pages = [...Object.keys(webpackEntries).map((name) => new HtmlWebpackPlugin({
//   filename: `${name}.html`,
//   chunks: [name],
//   template: `./public/${name}.html`,
// }))];

module.exports = {
  entry: {
    ...webpackEntries,
  },
  devtool: "source-map",
  output: {
    path: path.join(__dirname, "/public/assets"),
    filename: "[name].js",
  },
  devServer: {
    hot: true,
    open: true,
    port: 3001,
    proxy: {
      '*': {
        target: 'http://localhost/public',
      }
    },
    static: {
      publicPath: '/public/assets/',
      directory: path.join(__dirname, "/src"),
    }
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        include: [/src/],
        loader: "babel-loader",
      },
      {
        test: /\.(ts|js)x?$/,
        include: [/src/],
        loader: "ts-loader",
      },
    ],
  },
  resolve: {
    extensions: [ '.tsx', '.ts', '.jsx', '.js' ],
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    // new ReactRefreshWebpackPlugin(),
  ],
};
