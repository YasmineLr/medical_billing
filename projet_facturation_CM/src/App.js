import { BrowserRouter, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Acceuil from "./pages/Acceuil";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/Acceuil" element={<Acceuil />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
