"use client";
import { useState } from "react";
import { useAuthContext } from "../context/AuthContextProvider";
import { useRouter } from "next/navigation";

export default function AuthForm() {
  const { login, signup } = useAuthContext();
  const router = useRouter();

  const [isNewUser, setIsNewUser] = useState(false);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [username, setUsername] = useState("");
  const [errors, setErrors] = useState({});
  const [authError, setAuthError] = useState("");
  const [isLoading, setIsLoading] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsLoading(true);
    setAuthError("");
    setErrors({});

    const newErrors = {};
    if (!email) newErrors.email = "Email is required";
    if (!password) newErrors.password = "Password is required";
    if (isNewUser && !username) newErrors.username = "Username is required";

    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      setIsLoading(false);
      return;
    }

    try {
      if (isNewUser) {
        const result = await signup(username, email, password);
        if (result.success) {
          alert("Sign-up successful");
          router.push("/pages/home");
          // setIsNewUser(false);
        }
      } else {
        const result = await login(email, password);
        if (result.success) {
          router.push("/pages/home");
        }
      }
    } catch (error) {
      setAuthError(error.message || "An error occurred");
      console.error(isNewUser ? "Sign-up failed:" : "Login failed:", error);
    } finally {
      setIsLoading(false);
    }
  };

  const handleToggleMode = () => {
    setIsNewUser(!isNewUser);
    setErrors({});
    setAuthError("");
  };

  return (
    <main className="flex items-center justify-center w-full ">
    <div className="w-full max-w-md p-8 space-y-6 bg-white/10 bg-opacity-40  rounded-lg shadow-lg transition-all duration-500 hover:scale-105">
        <h2 className="text-2xl font-bold text-center text-white">
        {isNewUser ? "Sign up" : "Login"}
        </h2>

        {authError && (
        <div className="p-3 text-sm text-red-500 bg-red-50 rounded-lg">
            {authError}
        </div>
        )}

        <form className="space-y-4" onSubmit={handleSubmit}>
        {isNewUser && (
            <div>
            <label
                htmlFor="username"
                className="block text-sm font-medium text-white"
            >
                Username
            </label>
            <input
                type="text"
                id="username"
                name="username"
                value={username}
                onChange={(e) => {
                setUsername(e.target.value);
                if (errors.username) setErrors({ ...errors, username: "" });
                }}
                className={`w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-400 bg-transparent text-white ${
                errors.username ? "border-red-500" : "border-gray-300"
                }`}
                disabled={isLoading}
            />
            {errors.username && (
                <p className="mt-1 text-sm text-red-500">{errors.username}</p>
            )}
            </div>
        )}

        <div>
            <label
            htmlFor="email"
            className="block text-sm font-medium text-white"
            >
            Email
            </label>
            <input
            type="email"
            id="email"
            name="email"
            value={email}
            onChange={(e) => {
                setEmail(e.target.value);
                if (errors.email) setErrors({ ...errors, email: "" });
            }}
            className={`w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-400 bg-transparent text-white ${
                errors.email ? "border-red-500" : "border-gray-300"
            }`}
            disabled={isLoading}
            />
            {errors.email && (
            <p className="mt-1 text-sm text-red-500">{errors.email}</p>
            )}
        </div>

        <div>
            <label
            htmlFor="password"
            className="block text-sm font-medium text-white"
            >
            Password
            </label>
            <input
            type="password"
            id="password"
            name="password"
            value={password}
            onChange={(e) => {
                setPassword(e.target.value);
                if (errors.password) setErrors({ ...errors, password: "" });
            }}
            className={`w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-transparent text-white ${
                errors.password ? "border-red-500" : "border-gray-300"
            }`}
            disabled={isLoading}
            />
            {errors.password && (
            <p className="mt-1 text-sm text-red-500">{errors.password}</p>
            )}
        </div>

        <button
            type="submit"
            className="w-full py-3 px-4 bg-white bg-opacity-30 text-white font-semibold rounded-lg hover:bg-white hover:bg-opacity-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 ease-in-out"
            disabled={isLoading}
        >
            {isLoading ? "Processing..." : isNewUser ? "Sign up" : "Sign in"}
        </button>
        </form>

        <p className="text-sm text-center text-gray-300">
        {isNewUser ? "Already have an account?" : "Don't have an account?"}{" "}
        <button
            onClick={handleToggleMode}
            className="text-white hover:underline focus:outline-none"
            disabled={isLoading}
        >
            {isNewUser ? "Sign in" : "Sign up"}
        </button>
        </p>
    </div>
    </main>

  );
}
