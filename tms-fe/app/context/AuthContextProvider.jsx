"use client";
import { createContext, useContext, useState, useEffect } from "react";
import { ApolloClient, InMemoryCache, createHttpLink, gql } from "@apollo/client";
import { setContext } from "@apollo/client/link/context";

const AuthContext = createContext();

export const useAuthContext = () => {
  return useContext(AuthContext);
};

function AuthServiceProvider({ children }) {
  const [user, setUser] = useState(() => {
    if (typeof window !== 'undefined') {
      const storedUser = localStorage.getItem('user');
      return storedUser ? JSON.parse(storedUser) : null;
    }
    return null;
  });
  const [token, setToken] = useState(() => {
    if (typeof window !== 'undefined') {
      return localStorage.getItem('token');
    }
    return null;
  });

  const httpLink = createHttpLink({
    uri: "http://127.0.0.1:8000/graphql",
  });

  const authLink = setContext((_, { headers }) => {
    return {
      headers: {
        ...headers,
        authorization: token ? `Bearer ${token}` : "",
      },
    };
  });

  const client = new ApolloClient({
    link: authLink.concat(httpLink),
    cache: new InMemoryCache(),
    defaultOptions: {
      mutate: {
        fetchPolicy: 'no-cache',
      },
      query: {
        fetchPolicy: 'no-cache',
      },
    },
  });

  const LOGIN_MUTATION = gql`
    mutation Login($email: String!, $password: String!) {
      login(email: $email, password: $password) {
        token
        user {
          id
          name
          email
        }
      }
    }
  `;

  const SIGNUP_MUTATION = gql`
    mutation Signup($name: String!, $email: String!, $password: String!) {
      signup(name: $name, email: $email, password: $password) {
        token
        user {
          id
          name
          email
        }
      }
    }
  `;

  const login = async (email, password) => {
    try {
      const { data } = await client.mutate({
        mutation: LOGIN_MUTATION,
        variables: { email, password },
      });

      if (data?.login) {
        const { token: newToken, user: userData } = data.login;
        setToken(newToken);
        setUser(userData);
        localStorage.setItem('token', newToken);
        localStorage.setItem('user', JSON.stringify(userData)); 
        return { success: true, user: userData };
      }

      throw new Error('Login failed');
    } catch (error) {
      console.error('Login error:', error);
      const errorMessage = error.graphQLErrors?.[0]?.message || error.message || 'Login failed';
      throw new Error(errorMessage);
    }
  };

  const signup = async (name, email, password) => {
    try {
      const { data } = await client.mutate({
        mutation: SIGNUP_MUTATION,
        variables: { name, email, password },
      });

      if (data?.signup) {
        const { token: newToken, user: userData } = data.signup;
        setToken(newToken);
        setUser(userData);
        localStorage.setItem('token', newToken);
        localStorage.setItem('user', JSON.stringify(userData)); 
        return { success: true, user: userData };
      }

      throw new Error('Signup failed');
    } catch (error) {
      console.error('Signup error:', error);
      const errorMessage = error.graphQLErrors?.[0]?.message || error.message || 'Signup failed';
      throw new Error(errorMessage);
    }
  };

  const logout = () => {
    setUser(null);
    setToken(null);
    localStorage.removeItem('token');
    localStorage.removeItem('user'); 
    client.clearStore();
  };

  const value = {
    user,
    token,
    login,
    signup,
    logout,
    isAuthenticated: !!token && !!user,
  };

  return (
    <AuthContext.Provider value={value}>
      {children}
    </AuthContext.Provider>
  );
}

export default AuthServiceProvider;
