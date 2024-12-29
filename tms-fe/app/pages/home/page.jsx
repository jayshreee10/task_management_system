"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import Sidebar from "@/app/components/Sidebar";
import Table from "@/app/components/Table";
import NotificationList from "@/app/components/NotificationList";
import { RiLogoutCircleLine } from "react-icons/ri";

export default function Home() {
  const [isOpen, setIsOpen] = useState(true);
  const router = useRouter();
  const handleLogout = () => {
    localStorage.clear();
    router.push("/");
  };

  return (
    <div className="flex flex-col justify-evenly bg-gradient-to-r from-gray-800 via-purple-700 to-black min-h-screen">
      <div
        className="absolute top-5 right-10 cursor-pointer"
        onClick={handleLogout}
      >
        <RiLogoutCircleLine color="white" size={24} title="logout" />
      </div>

      <div className="flex-1 p-8">
        <NotificationList />
        <Table />
      </div>
    </div>
  );
}
