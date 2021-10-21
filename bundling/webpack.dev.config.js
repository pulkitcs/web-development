const path = require("path");
const HtmlWebpackPlugin = require("html-webpack-plugin");
// const ReactRefreshWebpackPlugin = require('@pmmmwh/react-refresh-webpack-plugin');
const webpack = require("webpack");

module.exports = {
  entry: "./src/index.js",
  devtool: "source-map",
  output: {
    path: path.join(__dirname, "/build"),
    filename: "index.js",
  },
  devServer: {
    contentBase: path.join(__dirname, "/src"),
    hot: true,
    open: true,
    port: 3001,
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
    new HtmlWebpackPlugin({
      template: "./public/index.html",
    }),
  ],
};
