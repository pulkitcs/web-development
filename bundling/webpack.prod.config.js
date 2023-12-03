const path = require("path");
const webpackEntries = require("./webpack.entries.js");

module.exports = {
  entry: {
    ...webpackEntries
  },
  output: {
    asyncChunks: true,
    path: path.join(__dirname, "/public/assets"),
    filename: "[name].js",
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
  plugins: []
};
