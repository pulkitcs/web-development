const HtmlWebpackPlugin = require('html-webpack-plugin');
const path = require('path');

module.exports = ({
  entry: {
    main: "./client/index.js"
  },
  output: {
    path: path.resolve(__dirname, 'build'),
    filename: "bundle.js",
  },
  module: {
    rules: [
      { 
        test: /\.(js|jsx)/,
        include: [
          path.resolve(__dirname, "client")
        ],
        exclude: [/node_modules/, /.json/],
        loader: "babel-loader",
        options: {
          presets: ["@babel/preset-react", "@babel/preset-env"],
        },
      }
    ]
  },
  plugins: [
    new HtmlWebpackPlugin({
      template: './client/index.html',
    })
  ],
})