"use client";

function Loader() {
  return (
    <div className="flex justify-center items-center min-h-screen bg-slate-950">
      <div className="loader">
        <div className="dot"></div>
        <div className="dot"></div>
        <div className="dot"></div>
      </div>
      <style jsx>{`
        .loader {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 10px;
        }

        .dot {
          width: 15px;
          height: 15px;
          border-radius: 50%;
          background-color: #7c3aed; /* Purple */
          animation: bounce 1.2s infinite ease-in-out;
        }

        .dot:nth-child(2) {
          animation-delay: 0.2s;
        }

        .dot:nth-child(3) {
          animation-delay: 0.4s;
        }

        @keyframes bounce {
          0%,
          80%,
          100% {
            transform: scale(0);
          }
          40% {
            transform: scale(1);
          }
        }
      `}</style>
    </div>
  );
}

export default Loader;
