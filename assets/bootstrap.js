// ./assets/bootstrap.js
import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";

// Import your controllers here if you have any

const application = Application.start();
const context = require.context("./controllers", true, /\.js$/);
application.load(definitionsFromContext(context));
