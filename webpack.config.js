module.exports = {
  entry: "./js/src",
  output: {
    path: __dirname + "/js",
    filename: "marvel.js"
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader"
        }
      }
    ]
  }
};
