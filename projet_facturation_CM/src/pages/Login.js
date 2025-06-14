import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useState } from "react";

export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");

    // try {
    // //   const response = await axios.post("http://localhost:8000/api/login", {
    // //     email,
    // //     password,
    // //   });

    //   if (response.status === 200) {
    navigate("/Acceuil");
    //   }
    // } catch (err) {
    //   if (err.response?.status === 401) {
    //     setError("Identifiants incorrects");
    //   } else {
    //     setError("Erreur serveur");
    //   }
    // }
  };

  return (
    <div className="container mt-5">
      <h2>Connexion</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
          <label>Email</label>
          <input
            type="email"
            className="form-control"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
        </div>
        <div className="mb-3">
          <label>Mot de passe</label>
          <input
            type="password"
            className="form-control"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
        </div>
        <button className="btn btn-primary">Se connecter</button>
        {error && <div className="text-danger mt-2">{error}</div>}
      </form>
    </div>
  );
}
