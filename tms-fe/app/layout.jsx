"use client";
import AuthServiceProvider from "./context/AuthContextProvider.jsx";
import TaskServiceProvider from "./context/TaskContextProvider.jsx";
import { ApolloProvider } from "@apollo/client";
import { createApolloClient } from "./services/apolloClient.js";
import "./globals.css";
// import { NotificationProvider } from "./context/NotificationContext.jsx";
// import { ToastContainer } from "react-toastify";
// import "react-toastify/dist/ReactToastify.css";
const client = createApolloClient();

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body>
        <ApolloProvider client={client}>
          <AuthServiceProvider>
            <TaskServiceProvider>
              {/* <NotificationProvider> */}
                {children}
                {/* <ToastContainer /> */}
              {/* </NotificationProvider> */}
            </TaskServiceProvider>
          </AuthServiceProvider>
        </ApolloProvider>
      </body>
    </html>
  );
}
