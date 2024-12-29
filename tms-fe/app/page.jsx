import Login from './components/Login';

export default function Home() {
  return (
    <div className="flex flex-col  items-center justify-evenly min-h-screen bg-gradient-to-r from-gray-800 via-purple-700 to-black px-4 transition-all duration-500 ease-in-out">

      
      <header className="text-center">
        <h1 className="text-5xl font-extrabold  text-white hover:opacity-45 transition-all duration-300 ease-in-out">
          Welcome to Task Management System
        </h1>
       
      </header>     
        <Login />
    
    </div>
  );
}
