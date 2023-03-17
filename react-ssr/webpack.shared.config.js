import MiniCssExtractPlugin from "mini-css-extract-plugin";
import ESLintPlugin from "eslint-webpack-plugin";
import HTMLWebpackPlugin from "html-webpack-plugin";
import path from "path";

const devMode = process.env.NODE_ENV !== "production";

const config = {
  entry: "./src/index.jsx",

  output: {
    filename: "bundle.js",
    path: path.resolve("dist"),
    assetModuleFilename: 'assets/[hash][ext][query]'
  },

  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
        },
      },
      {
        test: /\.(tsx|ts)$/,
        exclude: /node_modules/,
        use: {
          loader: "ts-loader",
        },
      },
      {
        test: /\.(css|less)$/,
        exclude: /node_modules/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: "css-loader",
            options: {
              sourceMap: devMode,
              modules: {
                localIdentName: "[name]__[local]--[hash:base64:5]",
              },
            },
          },
          {
            loader: "less-loader",
            options: {
              sourceMap: devMode,
            }
          },
        ],
      }, 
      {
        test: /\.(png|gif|bmp|jpg|jpeg|ttf|otf|woff)/,
        type: 'asset/resource',
        exclude: /node_modules/,
      },
      {
        test: /\.svg/,
        type: 'asset/inline',
        exclude: /node_modules/,
      },
    ],
  },
  plugins: [
    new ESLintPlugin(),
    new HTMLWebpackPlugin({ template: "./public/index.html" }),
    new MiniCssExtractPlugin({
      filename: "[name].css",
      chunkFilename: "[id].css",
    })
  ],
};


export default config;