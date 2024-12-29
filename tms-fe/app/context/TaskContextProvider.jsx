"use client";
import { createContext, useContext, useState, useEffect, useMemo } from "react";
import { ApolloClient, InMemoryCache, createHttpLink, gql } from "@apollo/client";
import { setContext } from "@apollo/client/link/context";

const TaskContext = createContext();

export const useTaskContext = () => {
  return useContext(TaskContext);
};

function TaskServiceProvider({ children }) {
  const [tasks, setTasks] = useState([]);
  const [selectedTask, setSelectedTask] = useState(null);
  const [token, setToken] = useState(() => localStorage.getItem("token"));

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

  const client = useMemo(() => {
    return new ApolloClient({
      link: authLink.concat(httpLink),
      cache: new InMemoryCache(),
      defaultOptions: {
        mutate: { fetchPolicy: "no-cache" },
        query: { fetchPolicy: "no-cache" },
      },
    });
  }, [token]);

  const GET_TASKS_QUERY = gql`
    query GetTasksForUser($assignedTo: ID!) {
      tasksForUser(assigned_to: $assignedTo) {
        id
        title
        description
        due_date
        status
        team_id
        priority
        comments {
          user_id
          username
          comment
          timestamp
        }
      }
    }
  `;

  const fetchTasks = async () => {
    try {
      const user = localStorage.getItem("user");
      if (!user) {
        console.error("No user found in localStorage");
        return;
      }

      const parsedUser = JSON.parse(user);
      const assignedTo = parsedUser?.id;

      if (!assignedTo) {
        console.error("Invalid user data: Missing assignedTo ID");
        return;
      }

      const { data } = await client.query({
        query: GET_TASKS_QUERY,
        variables: { assignedTo },
      });

      if (data?.tasksForUser) {
        setTasks(data.tasksForUser);
        console.log("Fetched tasks:", data.tasksForUser);
      } else {
        console.error("No tasks found for user");
      }
    } catch (error) {
      console.error("Error fetching tasks:", error);
    }
  };

  const GET_TASK_BY_ID = gql`
    query GetTaskById($id: ID!) {
      task(id: $id) {
        id
        title
        description
        due_date
        priority
        status
        created_by
        assigned_to
        comments {
          user_id
          username
          comment
          timestamp
        }
      }
    }
  `;

  const fetchTaskById = async (id) => {
    try {
      const { data } = await client.query({
        query: GET_TASK_BY_ID,
        variables: { id },
      });

      if (data?.task) {
        console.log("Fetched task by ID:", data.task);
        setSelectedTask(data.task);
        return data.task;
      } else {
        console.error("No task found for the given ID");
        return null;
      }
    } catch (error) {
      console.error("Error fetching task by ID:", error);
      return null;
    }
  };

  const value = {
    tasks,
    selectedTask,
    setSelectedTask,
    fetchTasks,
    fetchTaskById,
  };

  return <TaskContext.Provider value={value}>{children}</TaskContext.Provider>;
}

export default TaskServiceProvider;
