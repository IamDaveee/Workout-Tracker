import { Client, Account } from "https://esm.sh/appwrite@latest";

const client = new Client()
  .setEndpoint("https://fra.cloud.appwrite.io/v1")
  .setProject("6922111200029e82c94f");

export const account = new Account(client);
