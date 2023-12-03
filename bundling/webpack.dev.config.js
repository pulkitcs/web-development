const path = require("path");
const HtmlWebpackPlugin = require("html-webpack-plugin");
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
    contentBase: path.join(__dirname, "/src"),
    hot: true,
    open: true,
    port: 3001,
    proxy: {
      '*': {
        target: 'http://localhost/public',
      }
    },
    publicPath: '/public/assets/'
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: [/node_modules/, /public/, /build/],
        include: [/src/],
        loader: "babel-loader",
      },
      {
        test: /\.(ts|js)x?$/,
        exclude: [/node_modules/, /public/, /build/],
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
