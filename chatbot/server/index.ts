import express, { Express } from "express";
import { createServer, Server } from "node:http";
import { resolve } from "node:path";
import process from "node:process";

import apiRoutes from "./api";

const PORT: Number | String = process.env.PORT || 8080;
const app: Express = express();
const server: Server = createServer(app);

app.use("/", express.static(resolve("./client/dist"))).use("/api", apiRoutes);

server.listen(PORT, () => console.log(`Server Started on port: ${PORT}`));
